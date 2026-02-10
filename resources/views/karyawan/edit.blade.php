@extends('layouts.app')

@section('content')
<div class="p-6 max-w-lg mx-auto bg-white">
    <h1 class="text-2xl font-bold mb-4">Ubah User</h1>
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        <form action="{{ route('karyawan.update', $karyawan->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="block mb-1">Username</label>
            <input type="text" name="username" class="w-full border p-2 rounded" value="{{$karyawan->username }}" required>
        </div>

        <div>
            <label class="block mb-1">Nama</label>
            <input type="text" name="name" class="w-full border p-2 rounded" value="{{ $karyawan->name }}" required>
        </div>
        
        <div>
            <label class="block mb-1">Email</label>
            <input type="email" name="email" class="w-full border p-2 rounded" value="{{$karyawan->email }}" required>
        </div>
        
        <div>
            <label class="block mb-1">Password (Kosongkan jika tidak diganti)</label>
            <input type="password" name="password" class="w-full border p-2 rounded" >
        </div>
        
        <div>
            <label class="block mb-1">No HP</label>
            <input type="number" name="no_hp" class="w-full border p-2 rounded" value="{{ $karyawan->no_hp }}" required>
        </div>
        <div>
            <label class="block mb-1">Alamat</label>
            <input type="text" name="alamat" class="w-full border p-2 rounded" value="{{  $karyawan->alamat }}" required>
        </div>
        <div>
            <label class="block mb-1">Departemen</label>
            <select name="departemens_id" class="w-full border p-2 rounded" required>
                <option value="">-- Pilih Departemen --</option>
                @foreach($departemens as $dep)
                    <option value="{{ $dep->id }}" {{ $karyawan->departemens_id == $dep->id ? 'selected' : '' }} >{{ $dep->nama_departemen }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block mb-1">Jabatan</label>
            <select name="jabatans_id" class="w-full border p-2 rounded" required>
                <option value="">-- Pilih Jabatan --</option>
                @foreach($jabatans as $jab)
                    <option value="{{ $jab->id }}" {{ $karyawan->jabatans_id == $jab->id ? 'selected' : '' }} >{{ $jab->nama_jabatan }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block mb-1">Role</label>
            <select name="role" class="w-full border p-2 rounded" required>
                <option value="admin" {{ $karyawan->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="karyawan" {{ $karyawan->role == 'karyawan' ? 'selected' : '' }} >Karyawan</option>
            </select>
        </div>

        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Simpan
        </button>
        <a href="{{ route('karyawan.index') }}" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Batal</a>
    </form>
</div>
@endsection
