<h1>Laporan Absensi</h1>
<table border="1" cellspacing="0" cellpadding="5" width="100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Tanggal</th>
            <th>Jam Masuk</th>
            <th>Jam Pulang</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($absensis as $a)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $a->user->name }}</td>
            <td>{{ $a->tanggal }}</td>
            <td>{{ $a->jam_masuk }}</td>
            <td>{{ $a->jam_pulang == '00:00:00' ? 'Belum Pulang' : $a->jam_pulang }}</td>
            <td>{{ ucfirst($a->status) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
