<?php

namespace App\Http\Controllers;
use App\Models\Absensi;
use App\Models\AttendanceSession;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Str;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $query = Absensi::with(['user.departemen', 'user.jabatan']);
        if (Auth::user()->role !== 'admin') {
            $query->where('users_id', auth()->id());
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        if ($request->filled('users_id')) {
            $query->where('users_id', $request->users_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('keterangan')) {
            $query->where('keterangan', $request->keterangan);
        }

        $absensis = $query->orderBy('tanggal', 'desc')->paginate(perPage: 8);
        $absensis->appends($request->all());

        $users = User::all();
        $today = now()->toDateString();

        return view('absensi.index', compact('absensis', 'users'));
    }

    public function create()
    {
        $users = User::all();
        return view('absensi.create', compact('users'));
    }
    public function store(Request $request)
    {
        $validate = $request->validate([
            'users_id' => 'required',
            'tanggal' => 'required|after_or_equal:today',
            'jam_masuk' => 'required',
            'jam_pulang' => 'required',
            'status' => 'required',
            'keterangan' => 'required'
        ]);
        if (Auth::user()->role != 'admin') {
            $validate['users_id'] = Auth::user()->id;
        }
        Absensi::create($validate);
        return redirect()->route('absensis.index')->with('success', 'Absensi berhasil ditambahkan');
    }
    public function edit($id)
    {
        $absensis = Absensi::find($id);
        $users = User::all();
        return view('absensi.edit', compact('users', 'absensis'));
    }
    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'users_id' => 'required',
            'tanggal' => 'required|after_or_equal:today',
            'jam_masuk' => 'required',
            'jam_pulang' => 'required',
            'status' => 'required',
            'keterangan' => 'required'
        ]);
        Absensi::findOrFail($id)->update($validate);
        return redirect()->route('absensis.index')->with('success', 'Data berhasil diupdate!');
    }
    public function destroy($id)
    {
        $absensis = Absensi::findOrFail($id);
        $absensis->delete();
        return redirect()->route('absensis.index')->with('success', 'Data berhasil dihapus!');
    }
    public function scan()
    {
        return view('absen.scan');
    }
    public function qr()
    {
        $session = AttendanceSession::create([
            'token' => Str::uuid(),
            'expired_at' => now()->addSeconds(60),
            'is_used' => false,
        ]);

        return view('absen.qr', compact('session'));
    }



    public function scanConfirm(Request $request)
    {

        $request->validate([
            'token' => 'required|uuid'
        ]);

        $user = Auth::user();
        $today = now()->toDateString();

        DB::beginTransaction();

        try {

            $session = AttendanceSession::where('token', $request->token)
                ->where('expired_at', '>=', now())
                ->where('is_used', false)
                ->lockForUpdate()
                ->first();
            if (!$session) {
                DB::rollBack();
                return redirect()->route('absensis.scan')
                    ->with('error', 'QR tidak valid atau kadaluarsa.');
            }


            $absensi = Absensi::where('users_id', $user->id)
                ->whereDate('tanggal', $today)
                ->first();

            if ($absensi) {

                if (is_null($absensi->jam_pulang)) {

                    $absensi->update([
                        'jam_pulang' => now()->toTimeString(),
                    ]);

                    $session->update(['is_used' => true]);

                    DB::commit();

                    return redirect()->route('absensis.index')
                        ->with('success', 'Jam pulang berhasil direkam.');
                }

                DB::rollBack();

                return redirect()->route('absensis.index')
                    ->with('info', 'Anda sudah absen hari ini.');
            }

            $bataswaktu = now()->setTime(8, 0, 0);

            $keterangan = now()->greaterThan($bataswaktu)
                ? 'Terlambat'
                : 'Tepat waktu';

            Absensi::create([
                'users_id' => $user->id,
                'tanggal' => $today,
                'jam_masuk' => now()->toTimeString(),
                'jam_pulang' => null,
                'status' => 'hadir',
                'keterangan' => $keterangan,
            ]);

            $session->update(['is_used' => true]);

            DB::commit();

            return redirect()->route('absensis.index')
                ->with('success', 'Absensi berhasil dicatat!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('absensis.scan')
                ->with('error', 'Terjadi kesalahan sistem.');
        }
    }


    public function rekap(Request $request)
    {
        $tanggal_mulai = $request->input('tanggal_mulai');
        $tanggal_selesai = $request->input('tanggal_selesai');

        $query = Absensi::select('users_id')
            ->selectRaw("SUM(status = 'hadir') as total_hadir")
            ->selectRaw("SUM(status = 'alpha') as total_alpha")
            ->selectRaw("SUM(status = 'izin') as total_izin")
            ->selectRaw("SUM(status = 'sakit') as total_sakit")
            ->selectRaw("SUM(status = 'lembur') as total_lembur")
            ->selectRaw("
        SEC_TO_TIME(
            SUM(
                CASE 
                    WHEN jam_masuk != '00:00:00' AND jam_pulang != '00:00:00'
                    THEN TIME_TO_SEC(TIMEDIFF(jam_pulang, jam_masuk))
                    ELSE 0
                END
            )
        ) as total_jam_kerja
    ")
            ->groupBy('users_id')
            ->with('user');

        if ($tanggal_mulai && $tanggal_selesai) {
            $query->whereBetween('tanggal', [$tanggal_mulai, $tanggal_selesai]);
        }

        $rekap = $query->get();

        return view('laporan.rekap', compact('rekap', 'tanggal_mulai', 'tanggal_selesai'));
    }

}

