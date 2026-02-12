@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-8 text-center">
                    <div class="inline-flex p-3 bg-white/20 rounded-full backdrop-blur-sm mb-4">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z">
                            </path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-white mb-2">Scan QR Karyawan</h2>
                    <p class="text-blue-100">Arahkan kamera ke QR Code karyawan</p>
                </div>

                <!-- Scanner Container -->
                <div class="p-6">
                    <div id="reader" class="mx-auto border-2 border-dashed border-gray-300 rounded-2xl p-1 bg-gray-50">
                    </div>

                    <!-- Status Messages -->
                    <div id="status-container" class="mt-6">
                        <div id="status" class="text-center hidden">
                            <!-- Dynamic status will appear here -->
                        </div>
                    </div>

                    <!-- Scanner Controls -->
                    <div class="flex items-center justify-center space-x-4 mt-6">
                        <button id="start-scanner"
                            class="px-6 py-2.5 bg-gradient-to-r from-green-500 to-green-600 text-white font-medium rounded-xl shadow-lg hover:from-green-600 hover:to-green-700 transform transition-all duration-200 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Mulai Scan</span>
                            </div>
                        </button>

                        <button id="stop-scanner"
                            class="px-6 py-2.5 bg-gradient-to-r from-gray-500 to-gray-600 text-white font-medium rounded-xl shadow-lg hover:from-gray-600 hover:to-gray-700 transform transition-all duration-200 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 hidden">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"></path>
                                </svg>
                                <span>Hentikan Scan</span>
                            </div>
                        </button>
                    </div>

                    <!-- Loading Indicator -->
                    <div id="loading" class="hidden mt-4">
                        <div class="flex items-center justify-center">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                            <span class="ml-3 text-gray-600">Memproses QR Code...</span>
                        </div>
                    </div>

                    <!-- Recent Scan History (Optional) -->
                    <div class="mt-8 border-t pt-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Riwayat Scan</h3>
                        <div id="scan-history" class="space-y-2">
                            <!-- History items will appear here -->
                            <p class="text-gray-500 text-sm text-center">Belum ada scan</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Card -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                <div class="flex items-start space-x-3">
                    <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h4 class="text-sm font-medium text-blue-800">Tips Scanning</h4>
                        <p class="text-sm text-blue-600 mt-1">
                            Pastikan QR Code berada dalam bingkai kamera dan pencahayaan cukup untuk hasil scan yang
                            optimal.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let html5QrcodeScanner = null;
            let scanned = false;
            let scanHistory = [];

            // DOM Elements
            const reader = document.getElementById("reader");
            const statusEl = document.getElementById("status");
            const statusContainer = document.getElementById("status-container");
            const startBtn = document.getElementById("start-scanner");
            const stopBtn = document.getElementById("stop-scanner");
            const loadingEl = document.getElementById("loading");
            const scanHistoryEl = document.getElementById("scan-history");

            // Show status message
            function showStatus(message, type = 'info') {
                statusEl.classList.remove('hidden');
                statusContainer.classList.remove('hidden');
                statusEl.classList.add('p-4', 'rounded-lg', 'text-center', 'font-medium');

                // Set style based on type
                statusEl.className = '';
                statusEl.classList.add('p-4', 'rounded-lg', 'text-center', 'font-medium');

                switch (type) {
                    case 'success':
                        statusEl.classList.add('bg-green-100', 'text-green-800', 'border', 'border-green-200');
                        break;
                    case 'error':
                        statusEl.classList.add('bg-red-100', 'text-red-800', 'border', 'border-red-200');
                        break;
                    case 'warning':
                        statusEl.classList.add('bg-yellow-100', 'text-yellow-800', 'border', 'border-yellow-200');
                        break;
                    default:
                        statusEl.classList.add('bg-blue-100', 'text-blue-800', 'border', 'border-blue-200');
                }

                statusEl.innerText = message;
            }

            // Add to scan history
            function addToHistory(text) {
                const timestamp = new Date().toLocaleTimeString('id-ID');
                const historyItem = {
                    text: text,
                    time: timestamp
                };

                scanHistory.unshift(historyItem);

                // Keep only last 5 scans
                if (scanHistory.length > 5) {
                    scanHistory.pop();
                }

                // Update history display
                updateHistoryDisplay();
            }

            // Update history display
            function updateHistoryDisplay() {
                if (scanHistory.length === 0) {
                    scanHistoryEl.innerHTML = '<p class="text-gray-500 text-sm text-center">Belum ada scan</p>';
                    return;
                }

                let html = '';
                scanHistory.forEach((item, index) => {
                    html += `
                    <div class="bg-gray-50 rounded-lg p-3 flex items-center justify-between hover:bg-gray-100 transition-colors">
                        <div class="flex items-center space-x-3 truncate">
                            <svg class="w-4 h-4 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-700 truncate max-w-[150px] sm:max-w-[200px]">${item.text}</span>
                        </div>
                        <span class="text-xs text-gray-500 flex-shrink-0">${item.time}</span>
                    </div>
                `;
                });

                scanHistoryEl.innerHTML = html;
            }

            function onScanSuccess(decodedText) {
                if (scanned) return;
                scanned = true;

                // Show loading
                loadingEl.classList.remove('hidden');

                // Add to history
                addToHistory(decodedText);

                showStatus('✓ QR Code berhasil di-scan! Mengalihkan...', 'success');

                if (!isValidUrl(decodedText)) {
                    showStatus('QR tidak valid', 'error');
                    loadingEl.classList.add('hidden');
                    scanned = false;
                    return;
                }

                showStatus('✓ QR Code berhasil di-scan! Mengalihkan...', 'success');

                setTimeout(() => {
                    window.location.href = decodedText;
                }, 1500);
                setTimeout(() => {
                    window.location.href = decodedText;
                }, 1500);
            }

            function onScanError(errorMessage) {
                // Don't show common errors to avoid spamming
                if (!errorMessage.includes('No MultiFormat Readers')) {
                    console.log(errorMessage);
                }
            }

            function initScanner() {
                if (html5QrcodeScanner) {
                    html5QrcodeScanner.clear();
                }

                scanned = false;

                html5QrcodeScanner = new Html5QrcodeScanner(
                    "reader",
                    {
                        fps: 10,
                        qrbox: 250,
                        aspectRatio: 1.0,
                        showTorchButtonIfSupported: true,
                        showZoomSliderIfSupported: true,
                        defaultZoomValueIfSupported: 2
                    },
                    false
                );

                html5QrcodeScanner.render(onScanSuccess, onScanError);

                // Update button states
                startBtn.classList.add('hidden');
                stopBtn.classList.remove('hidden');

                showStatus('Kamera aktif, arahkan ke QR Code', 'info');
            }

            function stopScanner() {
                if (html5QrcodeScanner) {
                    html5QrcodeScanner.clear();
                    html5QrcodeScanner = null;
                }

                // Update button states
                startBtn.classList.remove('hidden');
                stopBtn.classList.add('hidden');

                showStatus('Scanner dihentikan', 'warning');
            }

            // Event Listeners
            startBtn.addEventListener('click', initScanner);
            stopBtn.addEventListener('click', stopScanner);

            // Clean up on page unload
            window.addEventListener('beforeunload', function () {
                if (html5QrcodeScanner) {
                    html5QrcodeScanner.clear();
                }
            });
        });

    </script>

    <style>
        /* Custom styles for QR scanner */
        #reader {
            width: 100% !important;
            max-width: 400px;
            aspect-ratio: 1;
            overflow: hidden;
            border-radius: 1rem;
            margin: 0 auto;
        }

        #reader video {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover;
            border-radius: 0.75rem;
        }

        #reader__dashboard_section {
            padding: 0.5rem !important;
        }

        #reader__dashboard_section_csr button {
            background: linear-gradient(to right, #3B82F6, #2563EB) !important;
            color: white !important;
            padding: 0.5rem 1rem !important;
            border-radius: 0.5rem !important;
            font-weight: 500 !important;
            border: none !important;
            transition: all 0.2s !important;
        }

        #reader__dashboard_section_csr button:hover {
            transform: scale(1.05) !important;
        }

        #reader__camera_selection {
            border: 1px solid #E5E7EB !important;
            border-radius: 0.5rem !important;
            padding: 0.5rem !important;
            background-color: white !important;
        }
    </style>
@endsection