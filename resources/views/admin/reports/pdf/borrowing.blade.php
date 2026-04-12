<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8"/>
<title>Laporan Peminjaman</title>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 10px; color: #333; }
  .header { text-align: center; padding: 12px 0; border-bottom: 2px solid #F6C000; margin-bottom: 12px; }
  .header h1 { font-size: 16px; color: #e6a800; margin-bottom: 2px; }
  .header p { font-size: 9px; color: #666; }
  table { width: 100%; border-collapse: collapse; }
  thead tr { background: #F6C000; color: #fff; }
  thead th { padding: 6px 7px; text-align: left; font-size: 9px; }
  tbody tr:nth-child(even) { background: #fefce8; }
  tbody td { padding: 5px 7px; font-size: 9px; border-bottom: 1px solid #eee; }
  .badge { display: inline-block; padding: 2px 6px; border-radius: 3px; font-size: 8px; }
  .badge-dipinjam { background: #dbeafe; color: #1e40af; }
  .badge-dikembalikan { background: #d1fae5; color: #065f46; }
  .badge-terlambat { background: #fee2e2; color: #991b1b; }
  .footer { margin-top: 14px; font-size: 8px; color: #888; text-align: right; }
</style>
</head>
<body>
<div class="header">
  <h1>LAPORAN PEMINJAMAN BARANG</h1>
  <p>Dicetak pada: {{ now()->format('d M Y H:i') }}</p>
</div>

<table style="margin-bottom:12px; width:auto;">
  <tr>
    <td style="padding:3px 16px 3px 0; font-size:9px;">Total Peminjaman</td>
    <td style="font-weight:bold; font-size:9px;">: {{ $summary['total'] }}</td>
    <td style="padding:3px 20px; font-size:9px;">Dipinjam</td>
    <td style="font-weight:bold; font-size:9px;">: {{ $summary['dipinjam'] }}</td>
    <td style="padding:3px 20px; font-size:9px;">Dikembalikan</td>
    <td style="font-weight:bold; font-size:9px;">: {{ $summary['dikembalikan'] }}</td>
    <td style="padding:3px 20px; font-size:9px;">Terlambat</td>
    <td style="font-weight:bold; font-size:9px;">: {{ $summary['terlambat'] }}</td>
  </tr>
</table>

<table>
  <thead>
    <tr>
      <th style="width:28px">#</th>
      <th>Nama Barang</th>
      <th>Peminjam</th>
      <th>Tgl Pinjam</th>
      <th>Tgl Kembali</th>
      <th>Tgl Dikembalikan</th>
      <th>Status</th>
      <th>Keterangan</th>
    </tr>
  </thead>
  <tbody>
    @forelse($borrowings as $i => $b)
    <tr>
      <td>{{ $i + 1 }}</td>
      <td>{{ $b->item->name ?? '-' }}</td>
      <td>{{ $b->user->name ?? '-' }}</td>
      <td>{{ $b->borrow_date ? $b->borrow_date->format('d/m/Y') : '-' }}</td>
      <td>{{ $b->due_date ? $b->due_date->format('d/m/Y') : '-' }}</td>
      <td>{{ $b->return_date ? $b->return_date->format('d/m/Y') : '-' }}</td>
      <td><span class="badge badge-{{ $b->status }}">{{ ucfirst($b->status) }}</span></td>
      <td>{{ \Illuminate\Support\Str::limit($b->notes, 40) }}</td>
    </tr>
    @empty
    <tr><td colspan="8" style="text-align:center; color:#999; padding:12px;">Tidak ada data</td></tr>
    @endforelse
  </tbody>
</table>

<div class="footer">
  Total {{ $borrowings->count() }} peminjaman &nbsp;|&nbsp; {{ config('app.name') }}
</div>
</body>
</html>
