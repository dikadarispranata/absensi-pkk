<table>
    <!-- Judul Laporan -->
    <tr>
        <td colspan="8" align="center">
            <strong style="font-size:14px;">LAPORAN ABSENSI KARYAWAN</strong>
        </td>
    </tr>
    <tr>
        <td colspan="8" align="center">
            <strong style="font-size:13px;">PT SETRA PRABA PERKASA</strong>
        </td>
    </tr>
    <tr>
        <td colspan="8" align="center">
            <em>
                Periode:
                {{ \Carbon\Carbon::parse($mulai ?? request('tanggal_mulai'))->translatedFormat('d F Y') }}
                s/d
                {{ \Carbon\Carbon::parse($selesai ?? request('tanggal_selesai'))->translatedFormat('d F Y') }}
            </em>
        </td>
    </tr>
    <tr></tr> 
    <tr style="background-color: #f2f2f2; text-align: center;">
        <th>No</th>
        <th>Nama Karyawan</th>
        <th>Hadir</th>
        <th>Sakit</th>
        <th>Izin</th>
        <th>Alpha</th>
        <th>Lembur</th>
        <th>Total Jam Kerja</th>
    </tr>
    
    @foreach($rekap as $r)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $r->user->name }}</td>
            <td>{{ $r->total_hadir }}</td>
            <td>{{ $r->total_sakit }}</td>
            <td>{{ $r->total_izin }}</td>
            <td>{{ $r->total_alpha }}</td>
            <td>{{ $r->total_lembur }}</td>
            <td>{{ $r->total_jam_kerja ?? '00:00:00' }}</td>
        </tr>
    @endforeach
</table>
