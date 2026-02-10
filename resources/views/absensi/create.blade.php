@extends('layouts.app')

@section('content')
<div class="p-6 max-w-lg mx-auto bg-white">
    <h1 class="text-2xl font-bold mb-4">Tambah Absensi</h1>
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        <form action="{{ route('absensis.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block mb-1">User</label>
            <select name="users_id" class="w-full border p-2 rounded">
                <option value="">-- Pilih User --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block mb-1">Tanggal</label>
            <input type="date" name="tanggal" class="w-full border p-2 rounded">
        </div>
        <div>
            <label class="block mb-1">Jam Masuk</label>
            <input type="time" name="jam_masuk" class="w-full border p-2 rounded">
        </div>
        <div>
            <label class="block mb-1">Jam Pulang</label>
            <input type="time" name="jam_pulang" class="w-full border p-2 rounded">
        </div>
        <div>
            <label class="block mb-1">Status</label>
            <select name="status" class="w-full border p-2 rounded">
                <option value="">-- Pilih Jenis Status --</option>
                <option value="hadir">hadir</option>
                <option value="sakit">sakit</option>
                <option value="izin">izin</option>
                <option value="alpha">alpha</option>
                <option value="lembur">lembur</option>
            </select>
        </div>
        <div>
            <label class="block mb-1">Keterangan</label>
            <input type="text" name="keterangan" class="w-full border p-2 rounded">
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Simpan
        </button>
        <a href="{{ route('absensis.index') }}" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Batal</a>
    </form>
</div>

@endsection
