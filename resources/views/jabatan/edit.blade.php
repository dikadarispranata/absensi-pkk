@extends('layouts.app')

@section('content')
<div class="p-6 max-w-lg mx-auto bg-white">
    <h1 class="text-2xl font-bold mb-4">Ubah Jabatan</h1>
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        <form action="{{ route('jabatans.update', $jabatan->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="block mb-1">Jabatan</label>
            <input type="text" name="nama_jabatan" class="w-full border p-2 rounded" value="{{ old('jabatan', $jabatan->nama_jabatan) }}" required>
        </div>

        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Simpan
        </button>
        <a href="{{ route('jabatans.index') }}" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Batal</a>
    </form>
</div>
@endsection
