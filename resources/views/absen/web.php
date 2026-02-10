<?php
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\JadwalController;
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
Route::get('/dashboard', [AuthController::class, 'dashboard'])->middleware('auth');

Route::resource('karyawan', UserController::class)->except('show')->middleware('auth');
Route::resource('departemens', DepartemenController::class)->middleware('auth');
Route::resource('jabatans', JabatanController::class)->middleware(('auth'));
Route::resource('jadwals', JadwalController::class)->middleware('auth');
Route::resource('absensis', AbsensiController::class)->middleware('auth')->except('show');
Route::resource('izins', IzinController::class)->middleware('auth');

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/absensis/scan', [AbsensiController::class, 'scan'])->name('absensis.scan')->middleware('auth');
Route::get('/absensis/scan/confirm', [AbsensiController::class, 'scanConfirm'])->name('absensis.scanConfirm');
Route::get('/absensis/qr', [AbsensiController::class, 'qr'])->name('absensis.qr')->middleware('auth');
