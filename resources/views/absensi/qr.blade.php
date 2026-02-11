@extends('layouts.app')
@section('content')
    @if (Auth::user()->role == 'admin')
        <div class="flex flex-col items-center justify-center">
            <div class="p-6 text-center item">
                <h1 class="text-2xl font-bold mb-4">QR Absensi Hari Ini</h1>
                {!! QrCode::size(250)->generate($session->token) !!}
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
            <script>
                setTimeout(function () {
                    location.reload();
                }, 20000);
            </script>

        @endif
    @endif
@endsection