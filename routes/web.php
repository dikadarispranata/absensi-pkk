<?php
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;
use App\Models\Absensi;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');

Route::resource('karyawan', UserController::class)->except('show')->middleware('auth');
Route::resource('departemens', DepartemenController::class)->middleware('auth');
Route::resource('jabatans', JabatanController::class)->middleware(('auth'));
Route::resource('jadwals', JadwalController::class)->middleware('auth');
Route::resource('absensis', AbsensiController::class)->middleware('auth')->except('show');
Route::resource('izins', IzinController::class)->middleware('auth');

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/absen/scan', [AbsensiController::class, 'scan'])->name('absen.scan')->middleware('auth');
Route::get('/absensis/scan/confirm', [AbsensiController::class, 'scanConfirm'])->name('absen.scanConfirm');
Route::get('/absen/qr', [AbsensiController::class, 'qr'])->name('absen.qr')->middleware('auth');

Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.exportPdf');
Route::get('/laporan/rekap', [LaporanController::class, 'rekap'])->name('laporan.rekap');
Route::get('/laporan/export-excel', [LaporanController::class, 'exportExcel'])->name('laporan.exportExcel');
Route::get('/laporan/rekap/export', [App\Http\Controllers\LaporanController::class, 'exportRekapExcel'])->name('laporan.rekap.export');
Route::get('/laporan/rekap/pdf', [LaporanController::class, 'exportRekapPdf'])->name('laporan.rekap.pdf');

