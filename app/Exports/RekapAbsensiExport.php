<?php

namespace App\Exports;

use App\Models\Absensi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RekapAbsensiExport implements FromView, WithTitle, ShouldAutoSize
{
    protected $mulai, $selesai;

    public function __construct($mulai, $selesai)
    {
        $this->mulai = $mulai;
        $this->selesai = $selesai;
    }

    public function view(): View
    {
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
            ->whereBetween('tanggal', [$this->mulai, $this->selesai])
            ->groupBy('users_id')
            ->wherehas('user', function($query){
                $query->where('role', '!=',      'admin');
            })
            ->with('user')
            ->get();

        return view('laporan.export-rekap', compact('rekap'));
    }

    public function title(): string
    {
        return 'Rekap Absensi';
    }
}
