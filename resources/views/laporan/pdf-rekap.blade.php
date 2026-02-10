<h2 style="text-align:center;">LAPORAN REKAP ABSENSI KARYAWAN DI PT SETRA PRABA PERKASA</h2>
<p>Periode: {{ $tanggal_mulai }} s.d {{ $tanggal_selesai }}</p>

<table border="1" cellspacing="0" cellpadding="5" width="100%">
    <thead>
        <tr style="background-color:#f2f2f2;">
            <th>No</th>
            <th>Nama Karyawan</th>
            <th>Hadir</th>
            <th>Sakit</th>
            <th>Izin</th>
            <th>Alpha</th>
            <th>Lembur</th>
            <th>Total Jam Kerja</th>
        </tr>
    </thead>
    <tbody>
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
    </tbody>
</table>
