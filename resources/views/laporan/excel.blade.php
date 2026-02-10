<table>
    <thead>
        <tr>
            <th colspan="9" style="font-weight:bold; text-align:center; font-size:16px;">
                LAPORAN ABSENSI KARYAWAN
            </th>
        </tr>
        <tr>
            <th colspan="9" style="text-align:center;">
                Periode: {{ $tanggal_mulai }} s/d {{ $tanggal_selesai }}
            </th>
        </tr>
        <tr></tr>
        <tr style="background-color:#c9c9c9;">
            <th>No</th>
            <th>Nama Karyawan</th>
            <th>Departemen</th>
            <th>Jabatan</th>
            <th>Tanggal</th>
            <th>Jam Masuk</th>
            <th>Jam Pulang</th> 
            <th>Status</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($absensis as $index => $absensi)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $absensi->user->name }}</td>
                <td>{{ $absensi->user->departemen->nama_departemen ?? '-' }}</td>
                <td>{{ $absensi->user->jabatan->nama_jabatan ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($absensi->tanggal)->format('Y-m-d') }}</td>
                <td>{{ $absensi->jam_masuk }}</td>
                <td>
                    @if ($absensi->jam_pulang == '00:00:00')
                        Belum Pulang
                    @else
                        {{ $absensi->jam_pulang }}
                    @endif
                </td>
                <td>{{ ucfirst($absensi->status) }}</td>
                <td>{{ $absensi->keterangan }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
