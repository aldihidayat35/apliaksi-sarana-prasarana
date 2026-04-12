<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8"/>
<title>Laporan Tahunan {{ $year }}</title>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 10px; color: #333; }
  .header { text-align: center; padding: 14px 0; border-bottom: 2px solid #17C653; margin-bottom: 14px; }
  .header h1 { font-size: 16px; color: #17C653; margin-bottom: 2px; }
  .header h2 { font-size: 13px; color: #555; margin-bottom: 2px; }
  .header p { font-size: 9px; color: #666; }
  .summary { display: table; width: 100%; margin-bottom: 16px; border-collapse: collapse; }
  .summary-cell { display: table-cell; border: 1px solid #ccc; padding: 8px 12px; text-align: center; width: 25%; }
  .summary-cell .val { font-size: 18px; font-weight: bold; color: #1B84FF; }
  .summary-cell .lbl { font-size: 8px; color: #666; margin-top: 2px; }
  table { width: 100%; border-collapse: collapse; }
  thead tr { background: #17C653; color: #fff; }
  thead th { padding: 6px 8px; text-align: left; font-size: 9px; }
  tbody tr:nth-child(even) { background: #f0fdf4; }
  tbody td { padding: 5px 8px; font-size: 9px; border-bottom: 1px solid #eee; text-align: center; }
  tbody td:first-child { text-align: left; }
  .footer { margin-top: 14px; font-size: 8px; color: #888; text-align: right; }
</style>
</head>
<body>
<div class="header">
  <h1>LAPORAN TAHUNAN</h1>
  <h2>Tahun {{ $year }}</h2>
  <p>Dicetak pada: {{ now()->format('d M Y H:i') }}</p>
</div>

<table style="margin-bottom:16px; border-collapse:collapse;">
  <tr>
    <td style="border:1px solid #ccc; padding:8px 16px; text-align:center; width:100px;">
      <div style="font-size:18px; font-weight:bold; color:#1B84FF;">{{ $summary['total_items'] }}</div>
      <div style="font-size:8px; color:#666;">Total Barang</div>
    </td>
    <td style="border:1px solid #ccc; padding:8px 16px; text-align:center; width:100px;">
      <div style="font-size:18px; font-weight:bold; color:#F6C000;">{{ $summary['total_borrowings'] }}</div>
      <div style="font-size:8px; color:#666;">Peminjaman {{ $year }}</div>
    </td>
    <td style="border:1px solid #ccc; padding:8px 16px; text-align:center; width:100px;">
      <div style="font-size:18px; font-weight:bold; color:#F8285A;">{{ $summary['total_damages'] }}</div>
      <div style="font-size:8px; color:#666;">Kerusakan {{ $year }}</div>
    </td>
    <td style="border:1px solid #ccc; padding:8px 16px; text-align:center; width:160px;">
      <div style="font-size:13px; font-weight:bold; color:#17C653;">Rp {{ number_format($summary['total_value'], 0, ',', '.') }}</div>
      <div style="font-size:8px; color:#666;">Total Nilai Aset</div>
    </td>
  </tr>
</table>

<table>
  <thead>
    <tr>
      <th style="text-align:left; width:80px;">Bulan</th>
      <th>Barang Masuk</th>
      <th>Peminjaman</th>
      <th>Kerusakan</th>
    </tr>
  </thead>
  <tbody>
    @foreach($monthlyData as $m => $data)
    <tr>
      <td style="text-align:left;">{{ $data['month'] }}</td>
      <td>{{ $data['items'] }}</td>
      <td>{{ $data['borrowings'] }}</td>
      <td>{{ $data['damages'] }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

<div class="footer">
  {{ config('app.name') }} &nbsp;|&nbsp; Laporan Tahunan {{ $year }}
</div>
</body>
</html>
