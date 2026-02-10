@extends('layouts.app')
@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Izin</title>
        @livewireStyles
    </head>

    <body>
        <div class="p-5">
            <!-- Header dengan judul dan tombol tambah -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
                <h1 class="text-2xl font-bold text-gray-800">Data Izin</h1>
                
                @if (Auth::user()->role == 'admin')
                    <button onclick="openModal()"
                        class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 shadow-md w-full sm:w-auto">
                        Tambah Izin
                    </button>
                @endif
                @if (Auth::user()->role == 'karyawan')
                    <button onclick="openModal()"
                        class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 shadow-md w-full sm:w-auto">
                        Ajukan Izin
                    </button>
                @endif
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-lg font-semibold mb-4 text-gray-700 border-b pb-2">Filter Pencarian</h2>
                <form method="GET" action="{{ route('izins.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    <!-- @if (auth()->user()->role == 'admin')
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">Cari Karyawan</label>
                            <input list="usersList" name="users_id" 
                                class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                placeholder="Ketik nama user..." 
                                value="{{ request('users_id') }}">
                            <datalist id="usersList">
                                @foreach($users as $user)
                                    <option value="{{ $user->name }}">
                                @endforeach
                            </datalist>
                        </div>
                    @endif -->
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Jenis Izin</label>
                        <select name="izin" class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Jenis</option>
                            <option value="sakit" {{ request('izin') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                            <option value="Cuti" {{ request('izin') == 'Cuti' ? 'selected' : '' }}>Cuti</option>
                            <option value="Izin" {{ request('izin') == 'lembur' ? 'selected' : '' }}>Izin</option>
                            <option value="Lain-lain" {{ request('izin') == 'Lain-lain' ? 'selected' : '' }}>Lain-lain</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Status</label>
                        <select name="status" class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Status</option>
                            <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                            <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" 
                            value="{{ request('tanggal_mulai') }}"
                            class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" 
                            value="{{ request('tanggal_selesai') }}"
                            class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="flex items-end gap-2 lg:col-span-5">
                        <button type="submit" 
                            class="w-full px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200">
                            Filter
                        </button>
                        <a href="{{ route('izins.index') }}" 
                            class="w-full px-4 py-2.5 bg-red-500 text-white rounded-lg hover:bg-red-600 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition duration-200 text-center">
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
                                <th class="p-4 text-sm font-semibold text-left text-gray-700">Nama Karyawan</th>
                                <th class="p-4 text-sm font-semibold text-left text-gray-700">Tanggal Mulai</th>
                                <th class="p-4 text-sm font-semibold text-left text-gray-700">Tanggal Selesai</th>
                                <th class="p-4 text-sm font-semibold text-left text-gray-700">Jenis Izin</th>
                                <th class="p-4 text-sm font-semibold text-left text-gray-700">Alasan</th>
                                <th class="p-4 text-sm font-semibold text-left text-gray-700">Status</th>
                                @if (auth()->user()->role == 'admin')
                                    <th class="p-4 text-sm font-semibold text-left text-gray-700">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @php $no = 1; @endphp
                            @foreach ($izins as $izin)
                                <tr class="bg-white hover:bg-gray-50 transition duration-150">
                                    <td class="p-4 text-sm text-gray-700 whitespace-nowrap">{{ $izin->id }}</td>
                                    <td class="p-4 text-sm text-gray-700 whitespace-nowrap">{{ $izin->user->name }}</td>
                                    <td class="p-4 text-sm text-gray-700 whitespace-nowrap">{{ $izin->tanggal_mulai }}</td>
                                    <td class="p-4 text-sm text-gray-700 whitespace-nowrap">{{ $izin->tanggal_selesai }}</td>
                                    <td class="p-4 text-sm text-gray-700 whitespace-nowrap">
                                        @if ($izin->jenis_izin == "Cuti")
                                            <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">Cuti</span>
                                        @elseif ($izin->jenis_izin == "Sakit")
                                            <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">Sakit</span>
                                        @elseif ($izin->jenis_izin == "Izin")
                                            <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">Izin</span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">Lain-lain</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-sm text-gray-700">{{ $izin->alasan }}</td>
                                    <td class="p-4 text-sm text-gray-700 whitespace-nowrap">
                                        @if ($izin->status == "Pending")
                                            <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">Pending</span>
                                        @elseif($izin->status == "Disetujui")
                                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Disetujui</span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">Ditolak</span>
                                        @endif
                                    </td>
                                    @if (auth()->user()->role == 'admin')
                                        <td class="p-4 text-sm text-gray-700 whitespace-nowrap">
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('izins.edit', $izin->id) }}"
                                                    class="inline-flex items-center px-3 py-1.5 rounded-md text-sm font-medium bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 transition duration-200">
                                                    Edit
                                                </a>
                                                <form action="{{ route('izins.destroy', $izin->id) }}" method="POST"
                                                    class="inline delete-form">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="button"
                                                        class="inline-flex items-center px-3 py-1.5 rounded-md text-sm font-medium bg-red-500 text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300 transition duration-200">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $izins->links('pagination::tailwind') }}
                </div>
            </div>
        </div>

        <div id="backdrop" class="fixed inset-0 bg-black bg-opacity-50 z-[9998] hidden"></div>
        <div id="izinModal" class="fixed inset-0 z-[9999] hidden items-center justify-center bg-gray-900/60 backdrop-blur-sm">
            <div class="relative w-full max-w-md bg-white rounded-lg shadow-lg p-6 mx-4">
                <div class="mt-3">
                    <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                        @if (Auth::user()->role == 'admin')
                            <h3 class="text-xl font-bold text-gray-900">Tambah Izin</h3>
                        @else
                            <h3 class="text-xl font-bold text-gray-900">Ajukan Izin</h3>
                        @endif
                        <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition duration-200 text-2xl">
                            &times;
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

                    <form action="{{ route('izins.store') }}" method="POST" class="space-y-6 mt-4">
                        @csrf
                        
                        @if (Auth::user()->role == 'admin')
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700">User</label>
                                <select name="users_id" class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                    <option value="">-- Pilih User --</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('users_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <input type="hidden" name="users_id" value="{{ Auth::user()->id }}">
                        @endif

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" 
                                class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                value="{{ old('tanggal_mulai') }}"
                                required>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" 
                                class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                value="{{ old('tanggal_selesai') }}"
                                required>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">Jenis Izin</label>
                            <select name="jenis_izin" class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">-- Pilih Jenis Izin --</option>
                                <option value="Cuti" {{ old('jenis_izin') == 'Cuti' ? 'selected' : '' }}>Cuti</option>
                                <option value="Sakit" {{ old('jenis_izin') == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                                <option value="Izin" {{ old('jenis_izin') == 'Izin' ? 'selected' : '' }}>Izin</option>
                                <option value="Lain-lain" {{ old('jenis_izin') == 'Lain-lain' ? 'selected' : '' }}>Lain-Lain</option>
                            </select>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">Alasan</label>
                            <textarea name="alasan" class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" rows="3" required>{{ old('alasan') }}</textarea>
                        </div>

                        @if (Auth::user()->role == 'admin')
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700">Status</label>
                                <select name="status" class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="Disetujui" {{ old('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                                    <option value="Ditolak" {{ old('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                    <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                </select>
                            </div>
                        @else
                            <input type="hidden" name="status" value="Pending">
                        @endif

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

        @livewireScripts
    </body>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        
        @if ($errors->any())
            document.addEventListener('DOMContentLoaded', function () {
                openModal();
            });
        @endif
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
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
                showConfirmButton: false,
                timer: 2000
            })
        </script>
    @endif

    </html>
@endsection