<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\departemen;
use App\Models\jabatan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $users = User::with('departemen', 'jabatan');
        $departemens = departemen::all();
        $jabatans = jabatan::all();

        $jumlahkaryawan = User::where('role', 'karyawan')->count();
        $hadirHariIni = Absensi::whereDate('tanggal', $today)->where('status', 'hadir')->count();
        $terlambat = Absensi::where('Keterangan', 'Terlambat')->count();

        $hadirbulanini = Absensi::whereMonth('tanggal', Carbon::now()->month)->whereYear('tanggal', Carbon::now()->year)->where('status', 'hadir')->where('users_id', Auth::user()->id)->count();
        $trrlambatblnini = Absensi::whereMonth('tanggal', Carbon::now()->month)->whereYear('tanggal', Carbon::now()->year)->where('keterangan', 'Terlambat')->where('users_id', Auth::user()->id)->count();
        $alphablnini = Absensi::whereMonth('tanggal', Carbon::now()->month)->whereYear('tanggal', Carbon::now()->year)->where('status', 'alpha')->where('users_id', Auth::user()->id)->count();
        $izinblnini = Absensi::whereMonth('tanggal', Carbon::now()->month)->whereYear('tanggal', Carbon::now()->year)->where('status', 'izin')->where('users_id', Auth::user()->id)->count();
        $sakitblnini = Absensi::whereMonth('tanggal', Carbon::now()->month)->whereYear('tanggal', Carbon::now()->year)->where('status', 'sakit')->where('users_id', Auth::user()->id)->count();

        return view('dashboard', compact('jumlahkaryawan', 'hadirHariIni', 'terlambat', 'hadirbulanini', 'izinblnini', 'alphablnini', 'trrlambatblnini', 'sakitblnini', 'users', 'departemens', 'jabatans'));
    }
}
