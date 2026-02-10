@extends('layouts.app')

@section('content')
    <div class="p-6 text-center">
        <h2 class="text-xl font-bold mb-4">Scan QR Karyawan</h2>
        <div id="reader" class="mx-auto border rounded" style="width:300px"></div>
        <div id="result" class="mt-4 text-sm text-gray-600"></div>
    </div>

    <!-- LIBARY -->
    <script src="https://unpkg.com/html5-qrcode"></script>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let scanned = false;

            function onScanSuccess(decodedText) {
                if (scanned) return; //cegah scan duplikat
                scanned = true;

                // Redirect hanya 1 kali
                window.location.href = "/absensis/scan/confirm?code=" + encodeURIComponent(decodedText);

                //stop kamera supaya tidak baca ulang
                html5QrcodeScanner.clear();
            }

            const html5QrcodeScanner = new Html5QrcodeScanner("reader", {
                fps: 10,
                qrbox: 250
            });

            html5QrcodeScanner.render(onScanSuccess);
        });
    </script>
@endsection