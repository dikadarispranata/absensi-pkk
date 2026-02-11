@extends('layouts.app')
@section('content')
    @if (Auth::user()->role == 'admin')
        <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8">
            <div class="container mx-auto px-4">
                {{-- Kartu QR Utama --}}
                <div class="max-w-2xl mx-auto">
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">

                        {{-- Header dengan efek gradien --}}
                        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-5">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="bg-white/20 p-2 rounded-lg backdrop-blur-sm">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h1 class="text-xl font-bold text-white">QR Absensi Aktif</h1>
                                        <p class="text-blue-100 text-sm mt-0.5">Periode: 60 detik</p>
                                    </div>
                                </div>

                                {{-- Timer Countdown --}}
                                <div class="bg-white/10 px-4 py-2 rounded-lg backdrop-blur-sm border border-white/20">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-white animate-pulse" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="text-white font-medium" id="countdown-timer"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Body QR Code --}}
                        <div class="p-8">
                            <div class="flex flex-col items-center">

                                {{-- Area QR dengan efek shadow --}}
                                <div id="qr-area"
                                    class="bg-white p-4 rounded-xl shadow-lg border-2 border-gray-100 hover:border-blue-200 transition-all duration-300">
                                    <div class="p-2 bg-gradient-to-br from-gray-50 to-white rounded-lg">
                                        {!! QrCode::size(280)->generate(url('/absensis/scan/confirm?token=' . $session->token)) !!}
                                    </div>
                                </div>

                                {{-- Informasi Token --}}
                                <div class="mt-6 w-full max-w-md">
                                    <div class="bg-gradient-to-r from-gray-50 to-blue-50 rounded-xl p-4 border border-blue-100">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-2">
                                                <div class="bg-blue-100 p-2 rounded-lg">
                                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <span class="text-sm font-medium text-gray-600">Token Sesi:</span>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <code
                                                    class="bg-gray-800 text-green-400 px-4 py-2 rounded-lg font-mono text-sm tracking-wider">
                                                                            {{ $session->token }}
                                                                        </code>
                                                <button onclick="copyToken()"
                                                    class="text-gray-500 hover:text-blue-600 transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Status Masa Berlaku --}}
                                <div class="mt-4 w-full max-w-md">
                                    <div
                                        class="flex items-center justify-between bg-white p-4 rounded-xl border border-red-100 shadow-sm">
                                        <div class="flex items-center space-x-3">
                                            <div class="relative">
                                                <div class="absolute inset-0 bg-red-500 rounded-full animate-ping opacity-20">
                                                </div>
                                                <div class="relative bg-red-100 p-2 rounded-full">
                                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500">Berlaku sampai</p>
                                                <p class="font-bold text-red-600 text-lg" id="expiry-time">
                                                    {{ $session->expired_at->format('H:i:s') }}
                                                </p>
                                            </div>
                                        </div>
                                        <span
                                            class="px-3 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded-full border border-red-200">
                                            Aktif
                                        </span>
                                    </div>
                                </div>

                                {{-- Tombol Aksi --}}
                                <div class="mt-6 flex space-x-4">
                                    <button onclick="printQR()"
                                        class="flex items-center space-x-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-3 rounded-xl shadow-lg transition-all duration-200 transform hover:scale-105">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                                            </path>
                                        </svg>
                                        <span>Cetak QR</span>
                                    </button>

                                    <a href="{{ route('absensis.index') }}"
                                        class="flex items-center space-x-2 bg-white border-2 border-gray-300 hover:border-blue-500 text-gray-700 hover:text-blue-600 px-6 py-3 rounded-xl shadow-lg transition-all duration-200 transform hover:scale-105">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                        </svg>
                                        <span>Kembali</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Petunjuk Penggunaan --}}
                    <div class="mt-6 bg-white rounded-xl p-5 shadow-md border border-gray-100">
                        <div class="flex items-start space-x-4">
                            <div class="bg-blue-100 p-2 rounded-lg flex-shrink-0">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800 mb-1">Petunjuk Penggunaan</h4>
                                <p class="text-sm text-gray-600">Scan QR code ini menggunakan kamera perangkat siswa untuk
                                    melakukan absensi. QR code akan otomatis diperbarui setiap 60 detik.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Script untuk Countdown Timer dan Copy Token --}}
        <script>
            // Countdown Timer
            const expiryTime = {{ $session->expired_at->timestamp * 1000 }};

            function updateCountdown() {
                const now = new Date().getTime();
                const distance = expiryTime - now;

                if (distance <= 0) {
                    document.getElementById('countdown-timer').innerHTML = '00 detik';
                    clearInterval(countdownInterval);

                    // reload otomatis saat expired
                    location.reload();
                    return;
                }

                const seconds = Math.floor(distance / 1000);
                document.getElementById('countdown-timer').innerHTML =
                    seconds.toString().padStart(2, '0') + ' detik';
            }

            const countdownInterval = setInterval(updateCountdown, 1000);
            updateCountdown();
            // Copy Token Function
            function copyToken() {
                const token = "{{ $session->token }}";
                navigator.clipboard.writeText(token).then(function () {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Token berhasil disalin',
                        showConfirmButton: false,
                        timer: 1500,
                        background: '#fff',
                        iconColor: '#3b82f6'
                    });
                });
            }

            // Print QR Function (tetap sama)
            function printQR() {
                var qrContent = document.getElementById('qr-area').innerHTML;
                var printWindow = window.open('', '_blank');
                printWindow.document.write(`
                                            <html>
                                            <head>
                                                <title>Print QR Absensi</title>
                                                <style>
                                                    body { 
                                                        text-align: center; 
                                                        font-family: 'Inter', sans-serif;
                                                        padding: 40px;
                                                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                                                        min-height: 100vh;
                                                        display: flex;
                                                        align-items: center;
                                                        justify-content: center;
                                                    }
                                                    .qr-container {
                                                        background: white;
                                                        padding: 30px;
                                                        border-radius: 20px;
                                                        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
                                                        display: inline-block;
                                                    }
                                                    img { 
                                                        width: 300px; 
                                                        height: 300px; 
                                                    }
                                                    p { 
                                                        margin-top: 15px; 
                                                        font-size: 14px; 
                                                        color: #4a5568;
                                                    }
                                                    .token {
                                                        background: #f7fafc;
                                                        padding: 12px 24px;
                                                        border-radius: 10px;
                                                        font-family: monospace;
                                                        font-size: 18px;
                                                        color: #2d3748;
                                                        border: 1px solid #e2e8f0;
                                                        margin-top: 10px;
                                                    }
                                                </style>
                                            </head>
                                            <body>
                                                <div class="qr-container">
                                                    ${qrContent}
                                                    <div class="token">
                                                        Token: {{ $session->token }}
                                                    </div>
                                                </div>
                                                <script>window.print(); window.close();<\/script>
                                            </body>
                                            </html>
                                        `);
                printWindow.document.close();
            }
        </script>

        {{-- SweetAlert untuk Success --}}
        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 2000,
                    background: '#fff',
                    iconColor: '#3b82f6'
                })
            </script>
        @endif
    @endif
@endsection