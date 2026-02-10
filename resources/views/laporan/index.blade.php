@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Absensi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Laporan Absensi</h1>

        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form method="GET" action="{{ route('laporan.rekap') }}" class="flex flex-col md:flex-row gap-4">
            <div class="relative flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Periode</label>
                <div class="relative">
                    <select name="periode" class="w-full border border-gray-300 rounded-lg p-2.5 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none shadow-sm">
                        <option value="hari_ini" {{ $periode == 'hari_ini' ? 'selected' : '' }}>Hari Ini</option>
                        <option value="minggu_ini" {{ $periode == 'minggu_ini' ? 'selected' : '' }}>Minggu Ini</option>
                        <option value="bulan_ini" {{ $periode == 'bulan_ini' ? 'selected' : '' }}>Bulan Ini</option>
                        <option value="tahun_ini" {{ $periode == 'tahun_ini' ? 'selected' : '' }}>Tahun Ini</option>
                        <option value="custom" {{ $periode == 'custom' ? 'selected' : '' }}>Custom</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2 pt-5 text-gray-500">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" value="{{ $tanggal_mulai }}"
                    class="w-full border border-gray-300 rounded-lg p-2.5 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
            </div>
            
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" value="{{ $tanggal_selesai }}"
                    class="w-full border border-gray-300 rounded-lg p-2.5 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
            </div>

            <div class="flex items-end">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg flex items-center gap-2 transition duration-200 shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <i class="fas fa-filter"></i>
                    Tampilkan
                </button>
            </div>
        </form>
        </div>

        @if(isset($absensis) && count($absensis) > 0)
        <div class="mb-6 flex flex-wrap gap-2">
            <a href="{{ route('laporan.exportPdf', ['tanggal_mulai' => $tanggal_mulai, 'tanggal_selesai' => $tanggal_selesai]) }}"
               class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition duration-200">
                <i class="fas fa-file-pdf"></i>
                Export PDF
            </a>
            <a href="{{ route('laporan.exportExcel', ['tanggal_mulai' => $tanggal_mulai, 'tanggal_selesai' => $tanggal_selesai]) }}"
               class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition duration-200">
                <i class="fas fa-file-excel"></i>
                Export Excel
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b-2 border-gray-200">
                        <tr>
                            <th class="p-3 text-sm font-semibold text-left text-gray-700">No</th>
                            <th class="p-3 text-sm font-semibold text-left text-gray-700">Nama Karyawan</th>
                            <th class="p-3 text-sm font-semibold text-left text-gray-700">Departemen</th>
                            <th class="p-3 text-sm font-semibold text-left text-gray-700">Jabatan</th>
                            <th class="p-3 text-sm font-semibold text-left text-gray-700">Tanggal</th>
                            <th class="p-3 text-sm font-semibold text-left text-gray-700">Jam Masuk</th>
                            <th class="p-3 text-sm font-semibold text-left text-gray-700">Jam Pulang</th>
                            <th class="p-3 text-sm font-semibold text-left text-gray-700">Status</th>
                            <th class="p-3 text-sm font-semibold text-left text-gray-700">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($absensis as $index => $absensi)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="p-3 text-sm text-gray-700">{{ $index + 1 }}</td>
                                <td class="p-3 text-sm text-gray-700 font-medium">{{ $absensi->user->name }}</td>
                                <td class="p-3 text-sm text-gray-700">{{ $absensi->user->departemen->nama_departemen ?? '-' }}</td>
                                <td class="p-3 text-sm text-gray-700">{{ $absensi->user->jabatan->nama_jabatan ?? '-' }}</td>
                                <td class="p-3 text-sm text-gray-700 font-mono">{{ \Carbon\Carbon::parse($absensi->tanggal)->format('Y-m-d') }}</td>
                                <td class="p-3 text-sm text-gray-700">
                                    @if ($absensi->jam_masuk == '00:00:00')
                                        <span class="text-gray-500 font-semibold bg-gray-100 px-2 py-1 rounded-full text-xs">Belum Masuk</span>
                                    @else
                                        <span class="font-mono bg-blue-50 text-blue-700 px-2 py-1 rounded-full text-xs">{{ $absensi->jam_masuk }}</span>
                                    @endif
                                </td>
                                <td class="p-3 text-sm text-gray-700">
                                    @if ($absensi->jam_pulang == '00:00:00')
                                        <span class="text-gray-500 font-semibold bg-gray-100 px-2 py-1 rounded-full text-xs">Belum Pulang</span>
                                    @else
                                        <span class="font-mono bg-green-50 text-green-700 px-2 py-1 rounded-full text-xs">{{ $absensi->jam_pulang }}</span>
                                    @endif
                                </td>
                                <td class="p-3 text-sm">
                                    @switch($absensi->status)
                                        @case('izin')
                                            <span class="text-yellow-700 font-bold bg-yellow-100 px-2 py-1 rounded-full text-xs">Izin</span>
                                            @break
                                        @case('hadir')
                                            <span class="text-green-700 font-bold bg-green-100 px-2 py-1 rounded-full text-xs">Hadir</span>
                                            @break
                                        @case('sakit')
                                            <span class="text-red-700 font-bold bg-red-100 px-2 py-1 rounded-full text-xs">Sakit</span>
                                            @break
                                        @case('alpha')
                                            <span class="text-blue-700 font-bold bg-blue-100 px-2 py-1 rounded-full text-xs">Alpha</span>
                                            @break
                                        @default
                                            <span class="text-purple-700 font-bold bg-purple-100 px-2 py-1 rounded-full text-xs">Lembur</span>
                                    @endswitch
                                </td>
                                <td class="p-3 text-sm text-gray-700">{{ $absensi->keterangan }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <i class="fas fa-file-alt text-gray-300 text-5xl mb-4"></i>
            <p class="text-gray-600 text-lg">Silakan pilih rentang tanggal untuk menampilkan laporan.</p>
        </div>
        @endif
    </div>
</body>
</html>
@endsection
