<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Kerusakan per Lokasi</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1f2937; }
        h2 { margin: 0 0 6px; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #e5e7eb; padding: 6px 8px; text-align: left; }
        th { background: #f3f4f6; }
    </style>
</head>
<body>
    <h2>Laporan Kerusakan per Lokasi</h2>
    <div>Dicetak: {{ date('d M Y, H:i') }}</div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Lokasi</th>
                <th>Barang</th>
                <th>Tanggal</th>
                <th>Kondisi Sesudah</th>
                <th>Keterangan</th>
                <th>Pelapor</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $r)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $r->item->location->name ?? '-' }}</td>
                <td>{{ $r->item->name }}</td>
                <td>{{ $r->report_date->format('d M Y') }}</td>
                <td>{{ ucfirst(str_replace('_', ' ', $r->condition_after)) }}</td>
                <td>{{ $r->description }}</td>
                <td>{{ $r->reportedByUser->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
