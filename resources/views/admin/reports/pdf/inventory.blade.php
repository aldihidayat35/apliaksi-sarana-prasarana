<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8"/>
<title>Laporan Inventaris</title>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 10px; color: #333; }
  .header { text-align: center; padding: 12px 0; border-bottom: 2px solid #1B84FF; margin-bottom: 12px; }
  .header h1 { font-size: 16px; color: #1B84FF; margin-bottom: 2px; }
  .header p { font-size: 9px; color: #666; }
  .summary { display: flex; gap: 10px; margin-bottom: 12px; }
  .summary-box { border: 1px solid #ddd; border-radius: 4px; padding: 6px 10px; min-width: 100px; text-align: center; }
  .summary-box .val { font-size: 16px; font-weight: bold; }
  .summary-box .lbl { font-size: 8px; color: #666; }
  table { width: 100%; border-collapse: collapse; }
  thead tr { background: #1B84FF; color: #fff; }
  thead th { padding: 6px 7px; text-align: left; font-size: 9px; }
  tbody tr:nth-child(even) { background: #f9f9f9; }
  tbody td { padding: 5px 7px; font-size: 9px; border-bottom: 1px solid #eee; }
  .badge { display: inline-block; padding: 2px 6px; border-radius: 3px; font-size: 8px; }
  .badge-baik { background: #d1fae5; color: #065f46; }
  .badge-rusak_ringan { background: #fef3c7; color: #92400e; }
  .badge-rusak_berat { background: #fee2e2; color: #991b1b; }
  .badge-hilang { background: #f3e8ff; color: #5b21b6; }
  .footer { margin-top: 14px; font-size: 8px; color: #888; text-align: right; }
</style>
</head>
<body>
<div class="header">
  <h1>LAPORAN INVENTARIS BARANG</h1>
  <p>Dicetak pada: {{ now()->format('d M Y H:i') }}</p>
</div>

<table style="margin-bottom:12px; width:auto;">
  <tr>
    <td style="padding:3px 12px 3px 0; font-size:9px;">Total Barang</td>
    <td style="padding:3px 0; font-weight:bold; font-size:9px;">: {{ $summary['total'] }}</td>
    <td style="padding:3px 20px 3px 20px; font-size:9px;">Kondisi Baik</td>
    <td style="padding:3px 0; font-weight:bold; font-size:9px;">: {{ $summary['baik'] }}</td>
    <td style="padding:3px 20px 3px 20px; font-size:9px;">Total Nilai Aset</td>
    <td style="padding:3px 0; font-weight:bold; font-size:9px;">: Rp {{ number_format($summary['total_value'], 0, ',', '.') }}</td>
  </tr>
  <tr>
    <td style="padding:3px 12px 3px 0; font-size:9px;">Rusak Ringan</td>
    <td style="padding:3px 0; font-weight:bold; font-size:9px;">: {{ $summary['rusak_ringan'] }}</td>
    <td style="padding:3px 20px 3px 20px; font-size:9px;">Rusak Berat</td>
    <td style="padding:3px 0; font-weight:bold; font-size:9px;">: {{ $summary['rusak_berat'] }}</td>
    <td style="padding:3px 20px 3px 20px; font-size:9px;">Hilang</td>
    <td style="padding:3px 0; font-weight:bold; font-size:9px;">: {{ $summary['hilang'] }}</td>
  </tr>
</table>

<table>
  <thead>
    <tr>
      <th style="width:28px">#</th>
      <th>Nama Barang</th>
      <th>Kode</th>
      <th>Kategori</th>
      <th>Lokasi</th>
      <th>Kondisi</th>
      <th style="text-align:right">Nilai (Rp)</th>
      <th>Terdaftar</th>
    </tr>
  </thead>
  <tbody>
    @forelse($items as $i => $item)
    <tr>
      <td>{{ $i + 1 }}</td>
      <td>{{ $item->name }}</td>
      <td>{{ $item->code ?? '-' }}</td>
      <td>{{ $item->category->name ?? '-' }}</td>
      <td>{{ $item->location->name ?? '-' }}</td>
      <td>
        <span class="badge badge-{{ $item->condition }}">{{ ucfirst(str_replace('_', ' ', $item->condition)) }}</span>
      </td>
      <td style="text-align:right">{{ $item->price ? number_format($item->price, 0, ',', '.') : '-' }}</td>
      <td>{{ $item->created_at->format('d/m/Y') }}</td>
    </tr>
    @empty
    <tr><td colspan="8" style="text-align:center; color:#999; padding:12px;">Tidak ada data</td></tr>
    @endforelse
  </tbody>
</table>

<div class="footer">
  Total {{ $items->count() }} barang &nbsp;|&nbsp; {{ config('app.name') }}
</div>
</body>
</html>
