@extends('layouts.app')

@section('content')
<div class="p-6 max-w-lg mx-auto bg-white">
    <h1 class="text-2xl font-bold mb-4">Ubah izin</h1>
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        <form action="{{ route('izins.update', $izins->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="block mb-1">User</label>
            <select name="users_id" class="w-full border p-2 rounded" disabled>
                <option value="">-- Pilih User --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $user->id == $izins->users_id ? 'selected' : '' }}>{{ $user->name }}
                @endforeach
            </select>
        </div>
        <div>
            <label class="block mb-1">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" class="w-full border p-2 rounded" value="{{ $izins->tanggal_mulai }}" disabled>
        </div>
        <div>
            <label class="block mb-1">Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" class="w-full border p-2 rounded" value="{{ $izins->tanggal_selesai }}" disabled>
        </div>
        <div>
            <label class="block mb-1">Jenis Izin</label>
            <select name="jenis_izin" class="w-full border p-2 rounded" disabled>
                <option value="">-- Pilih Jenis Izin --</option>
                <option value="Cuti" {{ $izins->jenis_izin== 'Cuti' ? 'selected' : '' }}>Cuti</option>
                <option value="Sakit" {{ $izins->jenis_izin== 'Sakit' ? 'selected' : '' }}>Sakit</option>
                <option value="Izin" {{ $izins->jenis_izin== 'Izin' ? 'selected' : '' }}>Izin</option>
                <option value="Lain-lain" {{ $izins->jenis_izin== 'Lain-lain' ? 'selected' : '' }}>Lain-Lain</option>
            </select>
        </div>
        <div>
            <label class="block mb-1">Alasan</label>
            <input type="text" name="alasan" class="w-full border p-2 rounded" value="{{ $izins->alasan }}" disabled>
        </div>
        <div>
            <label class="block mb-1">Status</label>
            <select name="status" class="w-full border p-2 rounded" required>
                <option value="">-- Pilih Status --</option>
                <option value="Disetujui" {{ $izins->status== 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                <option value="Ditolak" {{ $izins->status== 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                <option value="Pending" {{ $izins->status== 'Pending' ? 'selected' : '' }}>Pending</option>
            </select>
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Simpan
        </button>
        <a href="{{ route('izins.index') }}" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Batal</a>
    </form>
</div>

@endsection
