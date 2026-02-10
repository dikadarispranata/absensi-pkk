@extends('layouts.app')

@section('content')
<div class="p-6 max-w-lg mx-auto bg-white">
    @if (Auth::user()->role == 'admin')
    <h1 class="text-2xl font-bold mb-4">Tambah izin</h1>
    @endif
    @if (Auth::user()->role == 'karyawan')
    <h1 class="text-2xl font-bold mb-4">Ajukan izin</h1>
    @endif
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        <form action="{{ route('izins.store') }}" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" name="users_id" value="{{ Auth::user()->id }}">
        <input type="hidden" name="status" value="pending">
        @if (Auth::user()->role == 'admin')
        <div>
            <label class="block mb-1">User</label>
            <select name="users_id" class="w-full border p-2 rounded" required>
                <option value="">-- Pilih User --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        @endif
        <div>
            <label class="block mb-1">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" class="w-full border p-2 rounded">
        </div>
        <div>
            <label class="block mb-1">Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" class="w-full border p-2 rounded">
        </div>
        <div>
            <label class="block mb-1">Jenis Izin</label>
            <select name="jenis_izin" class="w-full border p-2 rounded" required>
                <option value="">-- Pilih Jenis Izin --</option>
                <option value="Cuti">Cuti</option>
                <option value="Sakit">Sakit</option>
                <option value="Izin">Izin</option>
                <option value="Lain-lain">Lain-Lain</option>
            </select>
        </div>
        <div>
            <label class="block mb-1">Alasan</label>
            <input type="text" name="alasan" class="w-full border p-2 rounded">
        </div>
        @if (Auth::user()->role == 'admin')
        <div>
            <label class="block mb-1">Status</label>
            <select name="status" class="w-full border p-2 rounded" required>
                <option value="">-- Pilih Status --</option>
                <option value="Disetujui">Disetujui</option>
                <option value="Ditolak">Ditolak</option>
                <option value="Pending">Pending</option>
            </select>
        </div>
        @endif
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Simpan
        </button>
        <a href="{{ route('izins.index') }}" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Batal</a>
    </form>
</div>

@endsection
