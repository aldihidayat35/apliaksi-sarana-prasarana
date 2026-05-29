<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Kondisi Barang - Guru</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1f2937; }
        h2 { margin: 0 0 4px; }
        .subtitle { margin-bottom: 12px; color: #6b7280; }
        .summary { display: flex; gap: 16px; margin-bottom: 12px; }
        .summary-item { background: #f3f4f6; padding: 8px 12px; border-radius: 4px; }
        .summary-item strong { font-size: 18px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #e5e7eb; padding: 6px 8px; text-align: left; }
        th { background: #f3f4f6; }
    </style>
</head>
<body>
    <h2>Laporan Kondisi Barang</h2>
    <div class="subtitle">Dicetak oleh Guru pada {{ date('d M Y, H:i') }}</div>

    <div class="summary">
        <div class="summary-item"><strong>{{ $summary['total'] }}</strong> Total</div>
        <div class="summary-item"><strong>{{ $summary['baik'] }}</strong> Baik</div>
        <div class="summary-item"><strong>{{ $summary['rusak_ringan'] }}</strong> Rusak Ringan</div>
        <div class="summary-item"><strong>{{ $summary['rusak_berat'] + $summary['hilang'] }}</strong> Rusak Berat + Hilang</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Kondisi</th>
                <th>Lokasi</th>
                <th>Kategori</th>
                <th>Qty</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->code }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->condition_label }}</td>
                <td>{{ $item->location->name ?? '-' }}</td>
                <td>{{ $item->category->name ?? '-' }}</td>
                <td>{{ $item->quantity }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
