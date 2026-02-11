@extends('layouts.app')

@section('content')
<div class="p-6 text-center">
    <h2 class="text-xl font-bold mb-4">Scan QR Karyawan</h2>

    <div id="reader" style="width:300px" class="mx-auto"></div>
    <p id="status" class="mt-4 text-sm text-gray-600"></p>
</div>

<script src="https://unpkg.com/html5-qrcode"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    let scanned = false;

    function onScanSuccess(decodedText) {

        if (scanned) return;
        scanned = true;

        document.getElementById("status").innerText =
            "QR terdeteksi, redirect...";

        // LANGSUNG redirect ke isi QR
        window.location.href = decodedText;
    }

    const html5QrcodeScanner = new Html5QrcodeScanner(
        "reader",
        { fps: 10, qrbox: 250 },
        false
    );

    html5QrcodeScanner.render(onScanSuccess);
});
</script>
@endsection
