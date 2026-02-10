@extends('layouts.app')
@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Jabatan</title>
    </head>

    <body>
        <div class="p-5">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
                <h1 class="text-2xl font-bold text-gray-800">Data Jabatan</h1>
                
                <button onclick="openModal()"
                    class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 shadow-md flex items-center justify-center gap-2 w-full sm:w-auto">
                    Tambah Jabatan
                </button>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-lg font-semibold mb-4 text-gray-700 border-b pb-2">Filter Pencarian</h2>
                <form method="GET" action="{{ route('jabatans.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Cari Jabatan</label>
                        <input list="jabatanList" name="nama_jabatan" 
                            class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                            placeholder="Cari nama jabatan..."
                            value="{{ request('nama_jabatan') }}">
                        <datalist id="jabatanList">
                            @foreach ($jabatans as $jabatan)
                                <option value="{{ $jabatan->nama_jabatan }}">
                            @endforeach
                        </datalist>
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" 
                            class="w-full px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 flex items-center justify-center gap-2">
                            Cari
                        </button>
                        <a href="{{ route('jabatans.index') }}" 
                            class="w-full px-4 py-2.5 bg-red-500 text-white rounded-lg hover:bg-red-600 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition duration-200 flex items-center justify-center gap-2">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="overflow-auto">
                    <table class="w-full border-collapse">
                        <thead class="bg-gray-50 border-b-2 border-gray-200">
                            <tr>
                                <th class="p-4 text-sm font-semibold text-left text-gray-700">No</th>
                                <th class="p-4 text-sm font-semibold text-left text-gray-700">Jabatan</th>
                                <th class="p-4 text-sm font-semibold text-left text-gray-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @php $no = 1; @endphp
                            @foreach ($jabatans as $jabatan)
                                <tr class="bg-white hover:bg-gray-50 transition duration-150">
                                    <td class="p-4 text-sm text-gray-700 whitespace-nowrap">{{ $no++ }}</td>
                                    <td class="p-4 text-sm text-gray-700 whitespace-nowrap font-medium">{{ $jabatan->nama_jabatan }}</td>
                                    <td class="p-4 text-sm text-gray-700 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('jabatans.edit', $jabatan->id) }}"
                                                class="inline-flex items-center px-3 py-1.5 rounded-md text-sm font-medium bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 transition duration-200"
                                                aria-label="Edit item 1">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                    aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                                </svg>
                                                Edit
                                            </a>
                                            <form action="{{ route('jabatans.destroy', $jabatan->id) }}" method="POST"
                                                class="inline delete-form">
                                                @csrf
                                                @method('delete')
                                                <button type="button"
                                                    class="inline-flex items-center px-3 py-1.5 rounded-md text-sm font-medium bg-red-500 text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300 transition duration-200"
                                                    aria-label="Delete item 1">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                        aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M10 3h4a1 1 0 011 1v1H9V4a1 1 0 011-1z" />
                                                    </svg>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('.delete-form button').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                let form = this.closest('form');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data ini akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                })
            });
        });
    </script>
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
    @endif

    <div id="backdrop" class="fixed inset-0 bg-black bg-opacity-50 z-[9998] hidden"></div>
    <div id="izinModal" class="fixed inset-0 z-[9999] hidden items-center justify-center bg-gray-900/60 backdrop-blur-sm">
        <div class="relative w-full max-w-md bg-white rounded-lg shadow-lg p-6 mx-4">
            <div class="mt-3">
                <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-900">Tambah Jabatan</h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>

                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 p-3 rounded my-4">
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('jabatans.store') }}" method="POST" class="space-y-6 mt-4">
                    @csrf

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Nama Jabatan</label>
                        <input type="text" name="nama_jabatan" 
                            class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                            placeholder="Masukkan nama jabatan" 
                            value="{{ old('nama_jabatan') }}"
                            required>
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <button type="button" onclick="closeModal()"
                            class="px-5 py-2.5 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 focus:ring-2 focus:ring-gray-300 transition duration-200 font-medium">
                            Batal
                        </button>
                        <button type="submit" 
                            class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 transition duration-200 font-medium">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('backdrop').classList.remove('hidden');
            document.getElementById('izinModal').classList.remove('hidden');
            document.getElementById('izinModal').classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('backdrop').classList.add('hidden');
            document.getElementById('izinModal').classList.remove('flex');
            document.getElementById('izinModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        document.getElementById('backdrop').addEventListener('click', function () {
            closeModal();
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });
        
        document.getElementById('izinModal').addEventListener('click', function (event) {
            if (event.target === this) {
                closeModal();
            }
        });
        
        @if ($errors->any())
            document.addEventListener('DOMContentLoaded', function () {
                openModal();
            });
        @endif
    </script>

    </html>
@endsection