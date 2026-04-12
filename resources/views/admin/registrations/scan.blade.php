@extends('layouts.app')
@section('title', 'Scan QR Code')
@section('page-title', 'Scan QR Code')

@section('breadcrumb')
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.registrations.index') }}" class="text-muted text-hover-primary">Registrasi</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-gray-900">Scan QR Code</li>
</ul>
@endsection

@section('content')
<div class="row g-5 g-xl-8">
    <div class="col-xl-6">
        <div class="card card-flush">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="ki-duotone ki-scan-barcode fs-2 me-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span></i>
                    Scanner QR Code
                </h3>
            </div>
            <div class="card-body">
                <div class="mb-5">
                    <label class="form-label fw-bold">Masukkan ID Unik Barang</label>
                    <div class="input-group">
                        <input type="text" id="uniqueIdInput" class="form-control form-control-lg" placeholder="Contoh: BRL-ABC-00001" autofocus/>
                        <button class="btn btn-primary" id="searchBtn" type="button">
                            <i class="ki-duotone ki-magnifier fs-2"><span class="path1"></span><span class="path2"></span></i> Cari
                        </button>
                    </div>
                    <div class="form-text">Scan QR Code atau ketik ID unik barang secara manual</div>
                </div>

                <div class="separator my-5"></div>

                <!--begin::Camera Scanner-->
                <div class="text-center">
                    <div id="reader" style="width: 100%; max-width: 450px; margin: 0 auto; border-radius: 8px; overflow: hidden;"></div>
                    <div class="mt-4 d-flex justify-content-center gap-3">
                        <button class="btn btn-light-primary" id="startCamera" type="button">
                            <i class="ki-duotone ki-technology-2 fs-2"><span class="path1"></span><span class="path2"></span></i> Buka Kamera
                        </button>
                        <button class="btn btn-light-danger d-none" id="stopCamera" type="button">
                            <i class="ki-duotone ki-cross-circle fs-2"><span class="path1"></span><span class="path2"></span></i> Tutup Kamera
                        </button>
                    </div>
                    <div id="cameraStatus" class="form-text mt-2 text-muted"></div>
                </div>
                <!--end::Camera Scanner-->
            </div>
        </div>
    </div>

    <div class="col-xl-6">
        <div class="card card-flush" id="resultCard" style="display: none;">
            <div class="card-header">
                <h3 class="card-title">Hasil Pencarian</h3>
            </div>
            <div class="card-body" id="resultBody">
            </div>
        </div>

        <div class="card card-flush" id="emptyCard">
            <div class="card-body text-center py-15">
                <i class="ki-duotone ki-scan-barcode fs-5x text-gray-300 mb-5"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span></i>
                <p class="text-gray-500 fs-5">Scan QR Code atau masukkan ID unik untuk mencari barang</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('vendor-js')
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
@endpush

@push('custom-js')
<script>
let html5QrCode = null;
let isScanning = false;

document.getElementById('searchBtn').addEventListener('click', function() {
    searchItem();
});

document.getElementById('uniqueIdInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') searchItem();
});

// Camera controls
document.getElementById('startCamera').addEventListener('click', function() {
    startScanner();
});

document.getElementById('stopCamera').addEventListener('click', function() {
    stopScanner();
});

function startScanner() {
    var statusEl = document.getElementById('cameraStatus');
    statusEl.textContent = 'Memulai kamera...';

    html5QrCode = new Html5Qrcode("reader");

    html5QrCode.start(
        { facingMode: "environment" },
        {
            fps: 10,
            qrbox: { width: 250, height: 250 },
            aspectRatio: 1.0
        },
        function onScanSuccess(decodedText) {
            // Auto-fill and search
            document.getElementById('uniqueIdInput').value = decodedText;
            searchItem();
            // Beep sound feedback
            try {
                var ctx = new (window.AudioContext || window.webkitAudioContext)();
                var osc = ctx.createOscillator();
                osc.type = 'sine';
                osc.frequency.value = 800;
                osc.connect(ctx.destination);
                osc.start();
                setTimeout(function() { osc.stop(); ctx.close(); }, 150);
            } catch(e) {}
            stopScanner();
        },
        function onScanFailure() {
            // Ignore scan failures (continuous scanning)
        }
    ).then(function() {
        isScanning = true;
        document.getElementById('startCamera').classList.add('d-none');
        document.getElementById('stopCamera').classList.remove('d-none');
        statusEl.innerHTML = '<span class="text-success"><i class="fas fa-circle text-success fs-9 me-1"></i> Kamera aktif - Arahkan ke QR Code</span>';
    }).catch(function(err) {
        statusEl.innerHTML = '<span class="text-danger">Gagal mengakses kamera: ' + err + '</span>';
        console.error("Camera error:", err);
    });
}

function stopScanner() {
    if (html5QrCode && isScanning) {
        html5QrCode.stop().then(function() {
            html5QrCode.clear();
            isScanning = false;
            document.getElementById('startCamera').classList.remove('d-none');
            document.getElementById('stopCamera').classList.add('d-none');
            document.getElementById('cameraStatus').textContent = 'Kamera ditutup';
        }).catch(function(err) {
            console.error("Stop error:", err);
        });
    }
}

function searchItem() {
    var uniqueId = document.getElementById('uniqueIdInput').value.trim();
    if (!uniqueId) return;

    fetch('{{ route("admin.registrations.scan-result") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ unique_id: uniqueId })
    })
    .then(r => r.json())
    .then(data => {
        document.getElementById('emptyCard').style.display = 'none';
        document.getElementById('resultCard').style.display = 'block';

        if (data.found) {
            var d = data.data;
            document.getElementById('resultBody').innerHTML = `
                <div class="d-flex align-items-center mb-5">
                    <div class="symbol symbol-60px symbol-circle me-5">
                        <span class="symbol-label bg-light-success">
                            <i class="ki-duotone ki-check-circle fs-2x text-success"><span class="path1"></span><span class="path2"></span></i>
                        </span>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0">Barang Ditemukan!</h4>
                        <span class="text-muted">${d.unique_id}</span>
                    </div>
                </div>
                <table class="table table-row-bordered gy-3">
                    <tr><td class="fw-bold text-muted w-150px">Nama Barang</td><td class="fw-bold">${d.item_name}</td></tr>
                    <tr><td class="fw-bold text-muted">Kode Barang</td><td>${d.item_code}</td></tr>
                    <tr><td class="fw-bold text-muted">Kategori</td><td>${d.category}</td></tr>
                    <tr><td class="fw-bold text-muted">Lokasi</td><td>${d.location}</td></tr>
                    <tr><td class="fw-bold text-muted">Kondisi</td><td><span class="badge badge-light-${d.condition_badge}">${d.condition}</span></td></tr>
                    <tr><td class="fw-bold text-muted">Status</td><td>${d.is_borrowed ? '<span class="badge badge-light-warning">Dipinjam oleh: ' + d.borrowed_by + '</span>' : '<span class="badge badge-light-success">Tersedia</span>'}</td></tr>
                </table>
                <div class="mt-5">
                    <a href="${d.url}" class="btn btn-primary btn-sm">Lihat Detail Lengkap</a>
                </div>
            `;
        } else {
            document.getElementById('resultBody').innerHTML = `
                <div class="text-center py-10">
                    <i class="ki-duotone ki-information-2 fs-5x text-danger mb-5"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                    <h4 class="fw-bold text-danger">Barang Tidak Ditemukan</h4>
                    <p class="text-muted">ID "${uniqueId}" tidak terdaftar dalam sistem</p>
                </div>
            `;
        }
    });
}
</script>
@endpush
