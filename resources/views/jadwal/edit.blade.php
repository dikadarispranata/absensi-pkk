@extends('layouts.app')

@section('content')
<div class="p-6 max-w-lg mx-auto bg-white">
    <h1 class="text-2xl font-bold mb-4">Ubah Jadwal</h1>
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        <form action="{{ route('jadwals.update', $jadwal->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="block mb-1">Nama Shift</label>
            <input type="text" name="nama_shift" class="w-full border p-2 rounded" value="{{ $jadwal->nama_shift }}">
        </div>
        <div>
            <label class="block mb-1">Jam Masuk</label>
            <input type="time" name="jam_masuk" class="w-full border p-2 rounded" value="{{ $jadwal->jam_masuk }}">
        </div>
        <div>
            <label class="block mb-1">Jam Keluar</label>
            <input type="time" name="jam_keluar" class="w-full border p-2 rounded" value="{{ $jadwal->jam_keluar }}">
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Simpan
        </button>
        <a href="{{ route('jadwals.index') }}" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Batal</a>
    </form>
</div>

@endsection
