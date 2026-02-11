@extends('layouts.app')
@section('content')
    @if (Auth::user()->role == 'admin')
        <div class="flex flex-col items-center justify-center">
            <div class="p-6 text-center">
                <h1 class="text-2xl font-bold mb-4">
                    QR Absensi Aktif (60 Detik)
                </h1>

                {{-- QR berisi URL LENGKAP --}}
                {!! QrCode::size(250)->generate(
                url('/absensis/scan/confirm?token=' . $session->token)
            ) !!}

                <p class="mt-3 text-sm text-gray-500">
                    Token: {{ $session->token }}
                </p>

                <p class="text-sm text-red-500">
                    Berlaku sampai: {{ $session->expired_at->format('H:i:s') }}
                </p>
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