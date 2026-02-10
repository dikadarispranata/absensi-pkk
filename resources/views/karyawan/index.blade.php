@extends('layouts.app')
@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Karyawan</title>
        @livewireStyles
    </head>

    <body>
        <div class="p-5">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
                <h1 class="text-2xl font-bold text-gray-800">Data Karyawan</h1>
                
                <button onclick="openModal()"
                    class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 shadow-md flex items-center justify-center gap-2 w-full sm:w-auto">
                    Tambah Karyawan
                </button>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-lg font-semibold mb-4 text-gray-700 border-b pb-2">Filter Pencarian</h2>
                <form method="GET" action="{{ route('karyawan.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Cari Karyawan</label>
                        <input list="userList" name="name" class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Cari nama user...">
                        <datalist id="userList">
                            @foreach ($users as $user)
                                <option value="{{ $user->name }}">
                            @endforeach
                        </datalist>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Departemen</label>
                        <select name="departemens_id" class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Semua Departemen --</option>
                            @foreach($departemens as $departemen)
                                <option value="{{ $departemen->id }}" {{ request('departemens_id') == $departemen->id ? 'selected' : '' }}>
                                    {{ $departemen->nama_departemen }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Jabatan</label>
                        <select name="jabatans_id" class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Semua Jabatan --</option>
                            @foreach($jabatans as $jabatan)
                                <option value="{{ $jabatan->id }}" {{ request('jabatans_id') == $jabatan->id ? 'selected' : '' }}>
                                    {{ $jabatan->nama_jabatan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Role</label>
                        <select name="role" class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Semua Role --</option>
                            <option value="Admin" {{ request('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                            <option value="Karyawan" {{ request('role') == 'Karyawan' ? 'selected' : '' }}>Karyawan</option>
                        </select>
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" class="w-full px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 flex items-center justify-center gap-2">
                            Cari
                        </button>
                        <a href="{{ route('karyawan.index') }}" class="w-full px-4 py-2.5 bg-red-500 text-white rounded-lg hover:bg-red-600 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition duration-200 flex items-center justify-center gap-2">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

        <div class="overflow-auto rounded-lg shadow">
            <table class="w-full border-collapse">
                <thead class="bg-gray-50 border-b-2 border-gray-200">
                    <tr>
                        <th class="p-3 text-sm font-semibold text-left">No</th>
                        <th class="p-3 text-sm font-semibold text-left">Username</th>
                        <th class="p-3 text-sm font-semibold text-left">Nama</th>
                        <th class="p-3 text-sm font-semibold text-left">Email</th>
                        <th class="p-3 text-sm font-semibold text-left">No HP</th>
                        <th class="p-3 text-sm font-semibold text-left">Alamat</th>
                        <th class="p-3 text-sm font-semibold text-left">Departemen</th>
                        <th class="p-3 text-sm font-semibold text-left">Jabatan</th>
                        <th class="p-3 text-sm font-semibold text-left">Role</th>
                        <th class="p-3 text-sm font-semibold text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @php $no = 1; @endphp
                    @foreach ($users as $user)
                        <tr class="bg-white hover:bg-gray-50 transition duration-150">
                            <td class="p-3 text-sm text-gray-700 whitespace-nowrap">{{ $no++ }}</td>
                            <td class="p-3 text-sm text-gray-700 whitespace-nowrap">{{ $user->username }}</td>
                            <td class="p-3 text-sm text-gray-700 whitespace-nowrap">{{ $user->name }}</td>
                            <td class="p-3 text-sm text-gray-700 whitespace-nowrap">{{ $user->email }}</td>
                            <td class="p-3 text-sm text-gray-700 whitespace-nowrap">{{ $user->no_hp }}</td>
                            <td class="p-3 text-sm text-gray-700 whitespace-nowrap">{{ $user->alamat }}</td>
                            <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                                {{ $user->departemen ? $user->departemen->nama_departemen : '-' }}
                            </td>
                            <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                                {{ $user->jabatan ? $user->jabatan->nama_jabatan : '-' }}
                            </td>
                            <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $user->role == 'Admin' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('karyawan.edit', $user->id) }}"
                                        class="inline-flex items-center px-3 py-1.5 rounded-md text-sm font-medium bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 transition duration-200"
                                        aria-label="Edit item 1">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('karyawan.destroy', $user->id) }}" method="POST"
                                        class="inline delete-form">
                                        @csrf
                                        @method('delete')
                                        <button type=" submit"
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
            <div class="mt-4 justify-center">
                {{ $users->links('pagination::tailwind') }}
            </div>
        </div>
        </div>
        @livewireScripts
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

    </html>
    <div id="backdrop" class="fixed inset-0 bg-black bg-opacity-50 z-[9998] hidden"></div>
    <div id="izinModal" class="fixed inset-0 z-[9999] hidden items-center justify-center bg-gray-900/60 backdrop-blur-sm">
        <div class="relative w-full max-w-lg bg-white rounded-lg shadow-lg p-5 mx-4">
            <div class="mt-3">
                <div class="flex justify-between items-center pb-3 border-b">
                    <h3 class="text-xl font-bold text-gray-900">Tambah Karyawan</h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>

                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 p-3 rounded my-4">
                        <ul>
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
                        <button type="button" onclick="closeModal()"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition duration-200">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition duration-200">Simpan</button>
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
@endsection