<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8"/>
<title>Laporan Kerusakan</title>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 10px; color: #333; }
  .header { text-align: center; padding: 12px 0; border-bottom: 2px solid #F8285A; margin-bottom: 12px; }
  .header h1 { font-size: 16px; color: #F8285A; margin-bottom: 2px; }
  .header p { font-size: 9px; color: #666; }
  table { width: 100%; border-collapse: collapse; }
  thead tr { background: #F8285A; color: #fff; }
  thead th { padding: 6px 7px; text-align: left; font-size: 9px; }
  tbody tr:nth-child(even) { background: #fff5f5; }
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
  <h1>LAPORAN KERUSAKAN BARANG</h1>
  <p>Dicetak pada: {{ now()->format('d M Y H:i') }}</p>
</div>

<table style="margin-bottom:12px; width:auto;">
  <tr>
    <td style="padding:3px 16px 3px 0; font-size:9px;">Rusak Ringan</td>
    <td style="font-weight:bold; font-size:9px;">: {{ $damageSummary['rusak_ringan'] }}</td>
    <td style="padding:3px 20px; font-size:9px;">Rusak Berat</td>
    <td style="font-weight:bold; font-size:9px;">: {{ $damageSummary['rusak_berat'] }}</td>
    <td style="padding:3px 20px; font-size:9px;">Hilang</td>
    <td style="font-weight:bold; font-size:9px;">: {{ $damageSummary['hilang'] }}</td>
  </tr>
</table>

<table>
  <thead>
    <tr>
      <th style="width:28px">#</th>
      <th>Tanggal</th>
      <th>Nama Barang</th>
      <th>Kondisi Sebelum</th>
      <th>Kondisi Sesudah</th>
      <th>Keterangan</th>
      <th>Pelapor</th>
    </tr>
  </thead>
  <tbody>
    @forelse($reports as $i => $r)
    <tr>
      <td>{{ $i + 1 }}</td>
      <td>{{ $r->report_date->format('d/m/Y') }}</td>
      <td>{{ $r->item->name ?? '-' }}</td>
      <td><span class="badge badge-{{ $r->condition_before }}">{{ ucfirst(str_replace('_', ' ', $r->condition_before)) }}</span></td>
      <td><span class="badge badge-{{ $r->condition_after }}">{{ ucfirst(str_replace('_', ' ', $r->condition_after)) }}</span></td>
      <td>{{ \Illuminate\Support\Str::limit($r->description, 50) }}</td>
      <td>{{ $r->reportedByUser->name ?? '-' }}</td>
    </tr>
    @empty
    <tr><td colspan="7" style="text-align:center; color:#999; padding:12px;">Tidak ada data</td></tr>
    @endforelse
  </tbody>
</table>

<div class="footer">
  Total {{ $reports->count() }} laporan &nbsp;|&nbsp; {{ config('app.name') }}
</div>
</body>
</html>
