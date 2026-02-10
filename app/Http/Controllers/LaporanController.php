<?php

namespace App\Http\Controllers;

use App\Exports\AbsensiExport;
use App\Exports\RekapAbsensiExport;
use App\Models\Absensi;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $periode = $request->input('periode');
        $tanggal_mulai = $request->input('tanggal_mulai');
        $tanggal_selesai = $request->input('tanggal_selesai');
        // $rekap = Absensi::selectRaw("users_id, SUM(status = 'hadir') as total_hadir, SUM(status = 'sakit') as total_sakit, SUM(status = 'izin') as total_izin, SUM(status = 'alpha') as total_alpha, SUM(status = 'lembur') as total_lembur")->groupBy('users_id')->with('user')->get();
        switch ($periode) {
            case 'hari_ini':
                $tanggal_mulai = Carbon::today()->toDateString();
                $tanggal_selesai = Carbon::today()->toDateString();
                break;
            case 'minggu_ini':
                $tanggal_mulai = Carbon::now()->startOfWeek()->toDateString();
                $tanggal_selesai = Carbon::now()->endOfWeek()->toDateString();
                break;
            case 'tahun_ini':
                $tanggal_mulai = Carbon::now()->startOfYear()->toDateString();
                $tanggal_selesai = Carbon::now()->endOfYear()->toDateString();
                break;
            case 'bulan_ini':
                $tanggal_mulai = Carbon::now()->startOfMonth()->toDateString();
                $tanggal_selesai = Carbon::now()->endOfMonth()->toDateString();
                break;
        }
        $query = Absensi::with(['user.departemen', 'user.jabatan']);

        if (auth()->user()->role !== 'admin') {
            $query->where('users_id', auth()->id());
        }

        if ($tanggal_mulai && $tanggal_selesai) {
            $query->whereBetween('tanggal', [$tanggal_mulai, $tanggal_selesai]);
        }

        if (!$tanggal_mulai || !$tanggal_selesai) {
            $tanggal_mulai = now()->startOfMonth()->toDateString();
            $tanggal_selesai = now()->endOfMonth()->toDateString();
        }
        $absensis = $query->get();
        // $total_hadir  = $absensis->where('status', 'hadir')->count();
        // $total_izin  = $absensis->where('status', 'izin')->count();
        // $total_sakit  = $absensis->where('status', 'sakit')->count();
        // $total_alpha  = $absensis->where('status', 'alpha')->count();
        // $total_lembur  = $absensis->where('status', 'lembur')->count();

        return view('laporan.index', compact('absensis', 'tanggal_mulai', 'tanggal_selesai', 'periode'));
    }
    public function rekap(Request $request)
    {
        $periode = $request->input('periode');
        $tanggal_mulai = $request->input('tanggal_mulai');
        $tanggal_selesai = $request->input('tanggal_selesai');
        // $rekap = Absensi::selectRaw("users_id, SUM(status = 'hadir') as total_hadir, SUM(status = 'sakit') as total_sakit, SUM(status = 'izin') as total_izin, SUM(status = 'alpha') as total_alpha, SUM(status = 'lembur') as total_lembur")->groupBy('users_id')->with('user')->get();
        switch ($periode) {
            case 'hari_ini':
                $tanggal_mulai = Carbon::today()->toDateString();
                $tanggal_selesai = Carbon::today()->toDateString();
                break;
            case 'minggu_ini':
                $tanggal_mulai = Carbon::now()->startOfWeek()->toDateString();
                $tanggal_selesai = Carbon::now()->endOfWeek()->toDateString();
                break;
            case 'bulan_ini':
                $tanggal_mulai = Carbon::now()->startOfMonth()->toDateString();
                $tanggal_selesai = Carbon::now()->endOfMonth()->toDateString();
                break;
            case 'tahun_ini':
                $tanggal_mulai = Carbon::now()->startOfYear()->toDateString();
                $tanggal_selesai = Carbon::now()->endOfYear()->toDateString();
                break;
        }
        if (!$tanggal_mulai || !$tanggal_selesai) {
            $tanggal_mulai = now()->startOfMonth()->toDateString();
            $tanggal_selesai = now()->endOfMonth()->toDateString();
        }

        $rekap = Absensi::select('users_id')
            ->selectRaw("SUM(status = 'hadir') as total_hadir")
            ->selectRaw("SUM(status = 'sakit') as total_sakit")
            ->selectRaw("SUM(status = 'izin') as total_izin")
            ->selectRaw("SUM(status = 'alpha') as total_alpha")
            ->selectRaw("SUM(status = 'lembur') as total_lembur")
            ->selectRaw("
            SEC_TO_TIME(SUM(
                CASE 
                    WHEN jam_masuk != '00:00:00' AND jam_pulang != '00:00:00'
                    THEN TIME_TO_SEC(TIMEDIFF(jam_pulang, jam_masuk))
                    ELSE 0
                END
            )) as total_jam_kerja
        ")
            ->whereBetween('tanggal', [$tanggal_mulai, $tanggal_selesai])
            ->wherehas('user', function ($query) {
                $query->where('role', '!=', 'admin');
            })
            ->groupBy('users_id')
            ->with(['user.departemen', 'user.jabatan'])
            ->get();

        return view('laporan.rekap', compact('rekap', 'tanggal_mulai', 'tanggal_selesai', 'periode'));
    }

    public function exportPdf(Request $request)
    {
        $absensis = Absensi::with(['user.departemen', 'user.jabatan'])
            ->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_selesai])
            ->get();

        $pdf = Pdf::loadView('laporan.pdf', compact('absensis'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-absensi.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new AbsensiExport($request->tanggal_mulai, $request->tanggal_selesai),
            'laporan-absensi.xlsx'
        );
    }
    public function exportRekapExcel(Request $request)
    {
        $tanggal_mulai = $request->input('tanggal_mulai');
        $tanggal_selesai = $request->input('tanggal_selesai');

        return Excel::download(
            new RekapAbsensiExport($tanggal_mulai, $tanggal_selesai),
            'rekap-absensi-' . now()->format('d-M-Y') . '.xlsx'
        );
    }
    public function exportRekapPdf(Request $request)
    {
        $periode = $request->input('periode');
        $tanggal_mulai = $request->input('tanggal_mulai');
        $tanggal_selesai = $request->input('tanggal_selesai');

        $rekap = Absensi::select('users_id')
            ->selectRaw("SUM(status = 'hadir') as total_hadir")
            ->selectRaw("SUM(status = 'sakit') as total_sakit")
            ->selectRaw("SUM(status = 'izin') as total_izin")
            ->selectRaw("SUM(status = 'alpha') as total_alpha")
            ->selectRaw("SUM(status = 'lembur') as total_lembur")
            ->selectRaw("
            SEC_TO_TIME(SUM(
                CASE 
                    WHEN jam_masuk != '00:00:00' AND jam_pulang != '00:00:00'
                    THEN TIME_TO_SEC(TIMEDIFF(jam_pulang, jam_masuk))
                    ELSE 0
                END
            )) as total_jam_kerja
        ")
            ->whereBetween('tanggal', [$tanggal_mulai, $tanggal_selesai])
            ->wherehas('user', function ($query) {
                $query->where('role', '!=', 'admin');
            })      
            ->groupBy('users_id')
            ->with('user')
            ->get();

        $pdf = Pdf::loadView('laporan.pdf-rekap', compact('rekap', 'tanggal_mulai', 'tanggal_selesai'))
            ->setPaper('A4', 'landscape');

        return $pdf->download('rekap-absensi-' . now()->format('d-M-Y') . '.pdf');
    }
}
