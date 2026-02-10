@extends('layouts.app')
@section('content')
@if (Auth::user()->role == 'admin')
<div class="flex flex-col items-center justify-center">
    <div class="p-6 text-center item">
        <h1 class="text-2xl font-bold mb-4">QR Absensi Hari Ini</h1>
        <div id="qr-area">
            {!! QrCode::size(250)->generate('ABSEN-' . now()->format('Y-m-d')) !!}
            <p class="mt-2 text-sm text-gray-500">{{ now()->format('d M Y') }}</p>
        </div>
        <button onclick="printQR()" 
            class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            🖨️ Print QR
        </button>
    </div>
</div>

@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000
        })
    </script>
@endif

<script>
    function printQR() {
        var qrContent = document.getElementById('qr-area').innerHTML;
        var printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <html>
            <head>
                <title>Print QR Absensi</title>
                <style>
                    body { text-align: center; font-family: sans-serif; }
                    img { width: 250px; height: 250px; }
                    p { margin-top: 10px; font-size: 14px; color: #555; }
                </style>
            </head>
            <body>
                ${qrContent}
                <script>window.print(); window.close();<\/script>
            </body>
            </html>
        `);
        printWindow.document.close();
    }
</script>
@endif
@endsection
