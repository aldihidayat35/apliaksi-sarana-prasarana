<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Bukti Pengembalian Barang</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1f2937; margin: 40px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #1f2937; padding-bottom: 20px; }
        .header h2 { margin: 0 0 4px; }
        .header p { margin: 0; color: #6b7280; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .info-table td { padding: 6px 8px; border: 1px solid #e5e7eb; }
        .info-table td:first-child { background: #f3f4f6; width: 35%; font-weight: bold; }
        .signature { margin-top: 40px; display: flex; justify-content: space-between; }
        .signature-box { text-align: center; width: 200px; }
        .signature-box .line { border-top: 1px solid #1f2937; margin-top: 60px; padding-top: 4px; }
        @media print { body { margin: 20px; } }
    </style>
</head>
<body>
    <div class="header">
        <h2>BUKTI PENGEMBALIAN BARANG</h2>
        <p>Sarana Prasarana Sekolah</p>
    </div>

    <table class="info-table">
        <tr>
            <td>Nama Peminjam</td>
            <td>{{ $borrowing->user->name ?? '-' }}</td>
        </tr>
        <tr>
            <td>Nama Barang</td>
            <td>{{ $borrowing->item->name ?? '-' }}</td>
        </tr>
        <tr>
            <td>Kode Barang</td>
            <td>{{ $borrowing->item->code ?? '-' }}</td>
        </tr>
        <tr>
            <td>Tanggal Pinjam</td>
            <td>{{ $borrowing->borrow_date?->format('d M Y') ?? '-' }}</td>
        </tr>
        <tr>
            <td>Tanggal Kembali (Direncanakan)</td>
            <td>{{ $borrowing->expected_return_date?->format('d M Y') ?? '-' }}</td>
        </tr>
        <tr>
            <td>Tanggal Dikembalikan</td>
            <td>{{ $borrowing->actual_return_date?->format('d M Y') ?? '-' }}</td>
        </tr>
        <tr>
            <td>Kondisi Saat Dikembalikan</td>
            <td>{{ ucfirst(str_replace('_', ' ', $borrowing->return_condition ?? '-')) }}</td>
        </tr>
        <tr>
            <td>Catatan Pengembalian</td>
            <td>{{ $borrowing->return_notes ?? '-' }}</td>
        </tr>
    </table>

    <div style="margin-top: 20px;">
        <strong>Status:</strong>
        @if($borrowing->status === 'dikembalikan')
            <span style="color: green;">Sudah Dikembalikan</span>
        @elseif($borrowing->status === 'terlambat')
            <span style="color: red;">Terlambat</span>
        @else
            <span style="color: orange;">Masih Dipinjam</span>
        @endif
    </div>

    <div class="signature">
        <div class="signature-box">
            <div>Peminjam</div>
            <div class="line">{{ $borrowing->user->name ?? '....................' }}</div>
        </div>
        <div class="signature-box">
            <div>Petugas</div>
            <div class="line">....................</div>
        </div>
    </div>

    <div style="text-align: center; margin-top: 30px; font-size: 10px; color: #9ca3af;">
        Dicetak pada: {{ date('d M Y, H:i') }}
    </div>
</body>
</html>
