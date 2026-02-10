<?php

namespace App\Exports;

use App\Models\Absensi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AbsensiExport implements FromView
{
    protected $tanggal_mulai;
    protected $tanggal_selesai;

    public function __construct($tanggal_mulai, $tanggal_selesai)
    {
        $this->tanggal_mulai = $tanggal_mulai;
        $this->tanggal_selesai = $tanggal_selesai;
    }

    public function view(): View
    {
        $absensis = Absensi::with(['user.departemen', 'user.jabatan'])
            ->whereBetween('tanggal', [$this->tanggal_mulai, $this->tanggal_selesai])
            ->get();

        return view('laporan.excel', [
            'absensis' => $absensis,
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_selesai' => $this->tanggal_selesai
        ]);
    }
}
