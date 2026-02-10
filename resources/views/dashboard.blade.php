@extends('layouts.app')

@section('content')
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard - Aplikasi Absensi Karyawan</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

            body {
                font-family: 'Inter', sans-serif;
            }

            .card-hover {
                transition: all 0.3s ease;
            }

            .card-hover:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            }

            .stat-icon {
                width: 48px;
                height: 48px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 16px;
            }
        </style>
    </head>

    <body class="bg-gray-50 min-h-screen">
        <div class="p-6">

            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Dashboard</h1>
                <p class="text-gray-600">Selamat datang di <span class="font-semibold text-blue-600">Aplikasi Absensi
                        Karyawan</span> 🚀</p>
            </div>

            @if (Auth::user()->role == 'admin')
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                    <div class="bg-white p-6 rounded-xl shadow-sm card-hover border border-gray-100">
                        <div class="stat-icon bg-blue-50 text-blue-600">
                            <i class="fas fa-users text-xl"></i>
                        </div>
                        <h2 class="text-gray-500 text-sm mb-2">Total Karyawan</h2>
                        <p class="text-3xl font-semibold text-blue-600">{{$jumlahkaryawan}}</p>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm card-hover border border-gray-100">
                        <div class="stat-icon bg-green-50 text-green-600">
                            <i class="fas fa-user-check text-xl"></i>
                        </div>
                        <h2 class="text-gray-500 text-sm mb-2">Hadir Hari Ini</h2>
                        <p class="text-3xl font-semibold text-green-600">{{ $hadirHariIni }}</p>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm card-hover border border-gray-100">
                        <div class="stat-icon bg-red-50 text-red-600">
                            <i class="fas fa-clock text-xl"></i>
                        </div>
                        <h2 class="text-gray-500 text-sm mb-2">Terlambat</h2>
                        <p class="text-3xl font-semibold text-red-600">{{ $terlambat ?? '0' }}</p>
                    </div>
                </div>
            @endif

            @if (Auth::user()->role == 'karyawan')
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

                    <div class="bg-white p-6 rounded-xl shadow-sm card-hover border border-gray-100">
                        <div class="stat-icon bg-green-50 text-green-600">
                            <i class="fas fa-calendar-check text-xl"></i>
                        </div>
                        <h2 class="text-gray-500 text-sm mb-2">Hadir Bulan Ini</h2>
                        <p class="text-3xl font-semibold text-green-600">{{ $hadirbulanini }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-sm card-hover border border-gray-100">
                        <div class="stat-icon bg-red-50 text-red-600">
                            <i class="fas fa-exclamation-circle text-xl"></i>
                        </div>
                        <h2 class="text-gray-500 text-sm mb-2">Terlambat Bulan Ini</h2>
                        <p class="text-3xl font-semibold text-red-600">{{ $terlambat ?? '0' }}</p>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm card-hover border border-gray-100">
                        <div class="stat-icon bg-blue-50 text-blue-600">
                            <i class="fas fa-user-times text-xl"></i>
                        </div>
                        <h2 class="text-gray-500 text-sm mb-2">Alpha Bulan Ini</h2>
                        <p class="text-3xl font-semibold text-blue-600">{{ $alphablnini ?? '0' }}</p>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm card-hover border border-gray-100">
                        <div class="stat-icon bg-purple-50 text-purple-600">
                            <i class="fas fa-procedures text-xl"></i>
                        </div>
                        <h2 class="text-gray-500 text-sm mb-2">Sakit Bulan Ini</h2>
                        <p class="text-3xl font-semibold text-purple-600">{{ $sakitblnini ?? '0' }}</p>
                    </div>
                </div>
            @endif
            <div class="mt-12">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Aksi Cepat</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @if (Auth::user()->role == 'admin')
                        <button onclick="openModal()"
                            class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 flex items-center hover:bg-blue-50 transition">
                            <div class="bg-blue-100 p-3 rounded-lg mr-4">
                                <i class="fas fa-user-plus text-blue-600"></i>
                            </div>
                            <span class="font-medium text-gray-700">Tambah Karyawan</span>
                        </button>

                        <a href="{{ route('laporan.rekap') }}"
                            class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 flex items-center hover:bg-green-50 transition">
                            <div class="bg-green-100 p-3 rounded-lg mr-4">
                                <i class="fas fa-file-export text-green-600"></i>
                            </div>
                            <span class="font-medium text-gray-700">Rekap Absensi</span>
                        </a>
                    @else
                        <a href="{{ route('absen.scan') }}"
                            class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 flex items-center hover:bg-blue-50 transition">
                            <div class="bg-blue-100 p-3 rounded-lg mr-4">
                                <i class="fas fa-fingerprint text-blue-600"></i>
                            </div>
                            <span class="font-medium text-gray-700">Absen Masuk dan Absen keluar</span>
                        </a>
                    @endif
                    <a href="{{ route('absensis.index') }}"
                        class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 flex items-center hover:bg-purple-50 transition">
                        <div class="bg-purple-100 p-3 rounded-lg mr-4">
                            <i class="fas fa-history text-purple-600"></i>
                        </div>
                        <span class="font-medium text-gray-700">Riwayat Absensi</span>
                    </a>
                </div>
            </div>
        </div>
    </body>

    </html>
@endsection

<div id="backdrop" class="fixed inset-0 bg-black bg-opacity-50 z-[9998] hidden"></div>
<div id="izinModal" class="fixed inset-0 z-[9999] hidden items-center justify-center bg-gray-900/60 backdrop-blur-sm">
    <div class="relative w-full max-w-lg bg-white rounded-lg shadow-lg p-5 mx-4">
        <div class="mt-3">
            <div class="flex justify-between items-center pb-3 border-b">
                <h3 class="text-xl font-bold text-gray-900">Tambah Karyawan</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
<!-- 
            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-3 rounded my-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif -->
            @if ($errors->any())
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        openModal();
                    });
                </script>
            @endif


            <form action="{{ route('karyawan.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block mb-1 font-medium">Username</label>
                        <input type="text" name="username" class="w-full border p-2 rounded" required>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Nama</label>
                        <input type="text" name="name" class="w-full border p-2 rounded" required>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Email</label>
                        <input type="email" name="email" class="w-full border p-2 rounded" required>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Password</label>
                        <input type="password" name="password" class="w-full border p-2 rounded" required>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">No HP</label>
                        <input type="number" name="no_hp" class="w-full border p-2 rounded" required>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Alamat</label>
                        <input type="text" name="alamat" class="w-full border p-2 rounded" required>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Departemen</label>
                        <select name="departemens_id" class="w-full border p-2 rounded" required>
                            <option value="">-- Pilih Departemen --</option>
                            @foreach($departemens as $dep)
                                <option value="{{ $dep->id }}">{{ $dep->nama_departemen }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Jabatan</label>
                        <select name="jabatans_id" class="w-full border p-2 rounded" required>
                            <option value="">-- Pilih Jabatan --</option>
                            @foreach($jabatans as $jab)
                                <option value="{{ $jab->id }}">{{ $jab->nama_jabatan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Role</label>
                        <select name="role" class="w-full border p-2 rounded" required>
                            <option value="admin">Admin</option>
                            <option value="karyawan">Karyawan</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <button type="button" onclick="closeModal()"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition duration-200">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition duration-200">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('backdrop').classList.remove('hidden');
        document.getElementById('izinModal').classList.remove('hidden');
        document.getElementById('izinModal').classList.add('flex');
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
    }

    function closeModal() {
        document.getElementById('backdrop').classList.add('hidden');
        document.getElementById('izinModal').classList.remove('flex');
        document.getElementById('izinModal').classList.add('hidden');
        document.body.style.overflow = 'auto'; // Restore scrolling
    }

    // Close modal when clicking on backdrop
    document.getElementById('backdrop').addEventListener('click', function () {
        closeModal();
    });

    // Close modal with ESC key
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeModal();
        }
    });

    // Close modal when clicking outside modal content
    document.getElementById('izinModal').addEventListener('click', function (event) {
        if (event.target === this) {
            closeModal();
        }
    });
</script>