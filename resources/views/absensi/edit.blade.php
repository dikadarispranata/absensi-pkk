@extends('layouts.app')

@section('content')
<div class="p-6 max-w-lg mx-auto bg-white">
    <h1 class="text-2xl font-bold mb-4">Ubah Absensi</h1>
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        <form action="{{ route('absensis.update', $absensis->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="block mb-1">User</label>
            <select name="users_id" class="w-full border p-2 rounded">
                <option value="">-- Pilih User --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $user->id == $absensis->users_id ? 'selected' : '' }}>{{ $user->name }}
                @endforeach
            </select>
        </div>
        <div>
            <label class="block mb-1">Tanggal</label>
            <input type="date" name="tanggal" class="w-full border p-2 rounded"
       value="{{ $absensis->tanggal ? $absensis->tanggal->format('Y-m-d') : '' }}">

        </div>
        <div>
            <label class="block mb-1">Jam Masuk</label>
            <input type="time" name="jam_masuk" class="w-full border p-2 rounded" value="{{ $absensis->jam_masuk }}">
        </div>
        <div>
            <label class="block mb-1">Jam Pulang</label>
            <input type="time" name="jam_pulang" class="w-full border p-2 rounded" value="{{ $absensis->jam_pulang }}">
        </div>
        <div>
            <label class="block mb-1">Status</label>
            <select name="status" class="w-full border p-2 rounded" required>
                <option value="">-- Pilih Status --</option>
                <option value="hadir" {{ $absensis->status == 'hadir' ? 'selected' : '' }}>hadir</option>
                <option value="izin" {{ $absensis->status == 'izin' ? 'selected' : '' }}>izin</option>
                <option value="sakit" {{ $absensis->status == 'sakit' ? 'selected' : '' }}>sakit</option>
                <option value="alpha" {{ $absensis->status == 'alpha' ? 'selected' : '' }}>alpha</option>
                <option value="lembur" {{ $absensis->status == 'lembur' ? 'selected' : '' }}>lembur</option>
            </select>
        </div>
        <div>
            <label class="block mb-1">Keterangan</label>
            <input type="text" name="keterangan" class="w-full border p-2 rounded" value="{{ $absensis->keterangan }}">
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Simpan
        </button>
        <a href="{{ route('absensis.index') }}" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Batal</a>
    </form>
</div>

@endsection
