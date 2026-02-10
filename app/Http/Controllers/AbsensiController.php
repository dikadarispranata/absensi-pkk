<?php

namespace App\Http\Controllers;
use App\Models\Absensi;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if ($request->filled('keterangan')){
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
        return view('absen.qr');
    }
    public function scanConfirm(Request $request)
    {
        $code = $request->query('code');
        $user = Auth::user();
        $today = now()->toDateString();

        if (!$code) {
            return redirect()->route('absen.scan')->with('error', 'QR tidak valid!');
        }

        $absensi = Absensi::where('users_id', $user->id)
            ->whereDate('tanggal', $today)
            ->first();

        if ($absensi) {
            if (empty($absensi->jam_pulang) || $absensi->jam_pulang == '00:00:00') {
                $absensi->update([
                    'jam_pulang' => now()->toTimeString(),
                    'status' => 'hadir',
                ]);
                return redirect()->route('absensis.index')->with('success', 'Jam pulang berhasil direkam.');
            } else {
                return redirect()->route('absensis.index')->with('info', 'Anda sudah absen hari ini.');
            }
        }

        $bataswaktu = now()->setTime(8, 0, 0);
        $jamsekarang = now();
        $keterangan = $jamsekarang->greaterThan($bataswaktu) ? 'Terlambat' : 'Tepat waktu';

        Absensi::create([
            'users_id' => Auth::user()->id,
            'tanggal' => now()->toDateString(),
            'jam_masuk' => now()->toTimeString(),
            'jam_pulang' => '00:00:00',
            'status' => 'hadir',
            'keterangan' => $keterangan,
        ]);

        return redirect()->route('absensis.index')->with('success', 'Absensi berhasil dicatat!');
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

