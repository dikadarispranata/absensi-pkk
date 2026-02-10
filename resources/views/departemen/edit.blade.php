@extends('layouts.app')

@section('content')
<div class="p-6 max-w-lg mx-auto bg-white">
    <h1 class="text-2xl font-bold mb-4">Ubah Departemen</h1>
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        <form action="{{ route('departemens.update', $departemen->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="block mb-1">Departemen</label>
            <input type="text" name="nama_departemen" class="w-full border p-2 rounded" value="{{ old('username', $departemen->nama_departemen) }}" required>
        </div>

        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Simpan
        </button>
        <a href="{{ route('departemens.index') }}" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Batal</a>
    </form>
</div>
@endsection
