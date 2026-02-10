@extends('layouts.app')

@section('content')
    <div class="p-6 max-w-5xl mx-auto bg-white rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-6">Tambah User</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-6">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('karyawan.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block mb-1 font-medium">Username</label>
                    <input type="text" name="username" class="w-full border p-2 rounded" required>
                </div>

                <div>
                    <label class="block mb-1 font-medium">Nama</label>
                    <input type="text" name="name" class="w-full border p-2 rounded" required>
                </div>

                <div>
                    <label class="block mb-1 font-medium">Email</label>
                    <input type="email" name="email" class="w-full border p-2 rounded" required>
                </div>

                <div>
                    <label class="block mb-1 font-medium">Password</label>
                    <input type="password" name="password" class="w-full border p-2 rounded" required>
                </div>

                <div>
                    <label class="block mb-1 font-medium">No HP</label>
                    <input type="number" name="no_hp" class="w-full border p-2 rounded" required>
                </div>

                <div>
                    <label class="block mb-1 font-medium">Alamat</label>
                    <input type="text" name="alamat" class="w-full border p-2 rounded" required>
                </div>

                <div>
                    <label class="block mb-1 font-medium">Departemen</label>
                    <select name="departemens_id" class="w-full border p-2 rounded" required>
                        <option value="">-- Pilih Departemen --</option>
                        @foreach($departemens as $dep)
                            <option value="{{ $dep->id }}">{{ $dep->nama_departemen }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-1 font-medium">Jabatan</label>
                    <select name="jabatans_id" class="w-full border p-2 rounded" required>
                        <option value="">-- Pilih Jabatan --</option>
                        @foreach($jabatans as $jab)
                            <option value="{{ $jab->id }}">{{ $jab->nama_jabatan }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-1 font-medium">Role</label>
                    <select name="role" class="w-full border p-2 rounded" required>
                        <option value="admin">Admin</option>
                        <option value="karyawan">Karyawan</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-4">
                <a href="{{ route('karyawan.index') }}"
                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
@endsection