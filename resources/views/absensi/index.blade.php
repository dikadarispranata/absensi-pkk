@extends('layouts.app')
@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Absensi</title>
        @livewireStyles
    </head>

    <body>
        <div class="p-5">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
                <h1 class="text-2xl font-bold text-gray-800">Data Absensi</h1>
                
                @if (auth()->user()->role == 'admin')
                    <button onclick="openModal()"
                        class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 shadow-md w-full sm:w-auto">
                        Tambah Absensi
                    </button>
                @endif
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-lg font-semibold mb-4 text-gray-700 border-b pb-2">Filter Pencarian</h2>
                <form method="GET" action="{{ route('absensis.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @if (auth()->user()->role == 'admin')
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">User</label>
                            <select name="users_id" class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua User</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ request('users_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Tanggal</label>
                        <input type="date" name="tanggal" 
                            value="{{ request('tanggal') }}"
                            class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Status</label>
                        <select name="status" class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Status</option>
                            <option value="hadir" {{ request('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                            <option value="izin" {{ request('status') == 'izin' ? 'selected' : '' }}>Izin</option>
                            <option value="sakit" {{ request('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                            <option value="alpha" {{ request('status') == 'alpha' ? 'selected' : '' }}>Alpha</option>
                            <option value="lembur" {{ request('status') == 'lembur' ? 'selected' : '' }}>Lembur</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Keterangan</label>
                        <select name="keterangan" class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Keterangan</option>
                            <option value="Terlambat" {{ request('keterangan') == 'Terlambat' ? 'selected' : '' }}>Terlambat</option>
                            <option value="Tepat waktu" {{ request('keterangan') == 'Tepat waktu' ? 'selected' : '' }}>Tepat waktu</option>
                            <option value="Tidak hadir" {{ request('keterangan') == 'Tidak hadir' ? 'selected' : '' }}>Tidak hadir</option>
                        </select>
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" 
                            class="w-full px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200">
                            Filter
                        </button>
                        <a href="{{ route('absensis.index') }}" 
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
                                <th class="p-4 text-sm font-semibold text-left text-gray-700">Departemen</th>
                                <th class="p-4 text-sm font-semibold text-left text-gray-700">Jabatan</th>
                                <th class="p-4 text-sm font-semibold text-left text-gray-700">Tanggal</th>
                                <th class="p-4 text-sm font-semibold text-left text-gray-700">Jam Masuk</th>
                                <th class="p-4 text-sm font-semibold text-left text-gray-700">Jam Pulang</th>
                                <th class="p-4 text-sm font-semibold text-left text-gray-700">Status</th>
                                <th class="p-4 text-sm font-semibold text-left text-gray-700">Keterangan</th>
                                @if (auth()->user()->role == 'admin')
                                    <th class="p-4 text-sm font-semibold text-left text-gray-700">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @php $no = 1; @endphp
                            @foreach ($absensis as $absensi)
                                <tr class="bg-white hover:bg-gray-50 transition duration-150">
                                    <td class="p-4 text-sm text-gray-700 whitespace-nowrap">{{ $absensi->id }}</td>
                                    <td class="p-4 text-sm text-gray-700 whitespace-nowrap">{{ $absensi->user->name }}</td>
                                    <td class="p-4 text-sm text-gray-700 whitespace-nowrap">{{ $absensi->user->departemen->nama_departemen }}</td>
                                    <td class="p-4 text-sm text-gray-700 whitespace-nowrap">{{ $absensi->user->jabatan->nama_jabatan }}</td>
                                    <td class="p-4 text-sm text-gray-700 whitespace-nowrap">{{ $absensi->tanggal->format('Y-m-d') }}</td>
                                    <td class="p-4 text-sm text-gray-700 whitespace-nowrap">
                                        @if ($absensi->jam_masuk == '00:00:00')
                                            <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">Belum Masuk</span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">{{ $absensi->jam_masuk }}</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-sm text-gray-700 whitespace-nowrap">
                                        @if ($absensi->jam_pulang == '00:00:00')
                                            <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">Belum Pulang</span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">{{ $absensi->jam_pulang }}</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-sm text-gray-700 whitespace-nowrap">
                                        @if ($absensi->status == "izin")
                                            <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">Izin</span>
                                        @elseif($absensi->status == "hadir")
                                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Hadir</span>
                                        @elseif($absensi->status == "sakit")
                                            <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">Sakit</span>
                                        @elseif($absensi->status == "alpha")
                                            <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">Alpha</span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-medium bg-purple-100 text-purple-800 rounded-full">Lembur</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-sm text-gray-700">{{ $absensi->keterangan }}</td>
                                    @if (auth()->user()->role == 'admin')
                                        <td class="p-4 text-sm text-gray-700 whitespace-nowrap">
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('absensis.edit', $absensi->id) }}"
                                                    class="inline-flex items-center px-3 py-1.5 rounded-md text-sm font-medium bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 transition duration-200">
                                                    Edit
                                                </a>
                                                <form action="{{ route('absensis.destroy', $absensi->id) }}" method="POST"
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
                    {{ $absensis->links('pagination::tailwind') }}
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
    @if (session('info'))
        <script>
            Swal.fire({
                icon: 'info',
                title: 'Informasi!',
                text: "{{ session('info') }}",
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
                    <h3 class="text-xl font-bold text-gray-900">Tambah Absensi</h3>
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

                <form action="{{ route('absensis.store') }}" method="POST" class="space-y-6 mt-4">
                    @csrf
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">User</label>
                        <select name="users_id" class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="">-- Pilih User --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('users_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Tanggal</label>
                        <input type="date" name="tanggal" 
                            class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                            value="{{ old('tanggal') }}"
                            required>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Jam Masuk</label>
                        <input type="time" name="jam_masuk" 
                            class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                            value="{{ old('jam_masuk') }}">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Jam Pulang</label>
                        <input type="time" name="jam_pulang" 
                            class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                            value="{{ old('jam_pulang') }}">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Status</label>
                        <select name="status" class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="hadir" {{ old('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                            <option value="sakit" {{ old('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                            <option value="izin" {{ old('status') == 'izin' ? 'selected' : '' }}>Izin</option>
                            <option value="alpha" {{ old('status') == 'alpha' ? 'selected' : '' }}>Alpha</option>
                            <option value="lembur" {{ old('status') == 'lembur' ? 'selected' : '' }}>Lembur</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Keterangan</label>
                        <input type="text" name="keterangan" 
                            class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                            placeholder="Masukkan keterangan"
                            value="{{ old('keterangan') }}">
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