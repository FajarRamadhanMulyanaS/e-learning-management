@extends('layout2.app')
@section('konten')

<style>
    .container-fluid {
        background-color: white;
    }

    h1 {
        font-family: Times, sans-serif;
        margin-left: 60px;
        margin-top: 20px;
    }

    .content {
        margin-left: 60px;
    }

    .presensi-card {
        transition: transform 0.2s;
        cursor: pointer;
    }

    .presensi-card:hover {
        transform: translateY(-2px);
    }

    .qr-scanner {
        max-width: 300px;
        margin: 0 auto;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1>PRESENSI ONLINE</h1>
            <div class="content">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('siswa.index')}}">Home</a></li>
                    <li class="breadcrumb-item"><span class="no-link">Presensi</span></li>
                    <li class="breadcrumb-item"><a href="#">Presensi Online</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="container mt-4">
    <!-- Sesi Presensi Aktif -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-clock"></i> Sesi Presensi Aktif Hari Ini</h5>
        </div>
        <div class="card-body">
            @if($activeSessions->count() > 0)
                <div class="row">
                    @foreach($activeSessions as $session)
                        <div class="col-md-6 mb-3">
                            <div class="card presensi-card border-primary">
                                <div class="card-body">
                                    <h6 class="card-title">{{ $session->mapel->nama_mapel }}</h6>
                                    @if($session->deskripsi)
                                        <p class="card-text text-primary">
                                            <i class="fas fa-info-circle"></i> {{ $session->deskripsi }}
                                        </p>
                                    @endif
                                    <p class="card-text">
                                        <small class="text-muted">
                                            <i class="fas fa-user"></i> {{ $session->guru->username }}<br>
                                            <i class="fas fa-clock"></i> {{ $session->jam_mulai_formatted }}<br>
                                            <i class="fas fa-calendar"></i> {{ $session->tanggal->format('d/m/Y') }}
                                        </small>
                                    </p>
                                    
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge {{ $session->mode === 'qr' ? 'badge-info' : 'badge-warning' }}">
                                            {{ strtoupper($session->mode) }}
                                        </span>
                                        
                                        <div>
                                            @if($session->mode === 'qr')
                                                <button class="btn btn-sm btn-primary" onclick="openQRScanner({{ $session->id }})">
                                                    <i class="fas fa-qrcode"></i> Scan QR
                                                </button>
                                            @else
                                                <button class="btn btn-sm btn-success" onclick="manualCheckIn({{ $session->id }})">
                                                    <i class="fas fa-check"></i> Hadir
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="mt-2">
                                        <small id="status-{{ $session->id }}" class="text-muted">Loading status...</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center text-muted">
                    <i class="fas fa-calendar-times fa-3x mb-3"></i>
                    <p>Tidak ada sesi presensi aktif untuk hari ini</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Riwayat Presensi -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-history"></i> Riwayat Presensi</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Mapel</th>
                            <th>Guru</th>
                            <th>Status</th>
                            <th>Waktu Absen</th>
                            <th>Metode</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($presensiHistory as $index => $record)
                            <tr>
                                <td>{{ $presensiHistory->firstItem() + $index }}</td>
                                <td>{{ $record->presensiSession->tanggal->format('d/m/Y') }}</td>
                                <td>{{ $record->presensiSession->mapel->nama_mapel }}</td>
                                <td>{{ $record->presensiSession->guru->username }}</td>
                                <td>
                                    <span class="badge {{ $record->status_badge_class }}">
                                        {{ $record->status_text }}
                                    </span>
                                </td>
                                <td>{{ $record->waktu_absen_formatted }}</td>
                                <td>
                                    @if($record->metode_absen)
                                        <span class="badge badge-info">{{ strtoupper($record->metode_absen) }}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada riwayat presensi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $presensiHistory->links() }}
            </div>
        </div>
    </div>
</div>

<!-- QR Scanner Modal -->
<div class="modal fade" id="qrScannerModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-qrcode"></i> Scan QR Code</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <div id="qr-reader" class="qr-scanner" style="width: 100%; max-width: 400px; margin: 0 auto;"></div>
                <p class="mt-3 text-muted">
                    <i class="fas fa-camera"></i> Arahkan kamera ke QR Code untuk melakukan absen
                </p>
                <div id="scanner-status" class="mt-2"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- Pastikan library eksternal dimuat lebih dulu -->
<!-- 1. jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- 2. Bootstrap (untuk modal) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- 3. DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- 4. QRCodeJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<!-- 5. HTML5 QR Code Scanner -->
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

<!-- Fallback untuk browser yang tidak mendukung -->
<script>
    // Check if HTML5 QR Code is available
    if (typeof Html5QrcodeScanner === 'undefined') {
        console.error('❌ HTML5 QR Code Scanner library tidak dimuat');
        document.addEventListener('DOMContentLoaded', function() {
            // Show fallback message if library fails to load
            const scannerButtons = document.querySelectorAll('button[onclick*="openQRScanner"]');
            scannerButtons.forEach(button => {
                button.onclick = function() {
                    alert('QR Scanner tidak tersedia. Silakan gunakan metode manual atau refresh halaman.');
                };
            });
        });
    }
</script>

<script>
    let currentSessionId = null;
    let html5QrcodeScanner = null;

    // Load presensi status for active sessions
    @foreach($activeSessions as $session)
        loadPresensiStatus({{ $session->id }});
    @endforeach

    function loadPresensiStatus(sessionId) {
        fetch(`/siswa/siswa/presensi/status/${sessionId}`)
            .then(response => response.json())
            .then(data => {
                const statusElement = document.getElementById(`status-${sessionId}`);
                const card = statusElement.closest('.card-body');
                const buttonContainer = card.querySelector('.d-flex div');

                if (data.status === 'tidak_hadir') {
                    statusElement.innerHTML = '<span class="text-danger">Belum absen</span>';
                } else {
                    let badgeClass = 'bg-success';
                    let textClass = 'text-success';
                    let statusText = data.status_text || 'Hadir';
                    
                    if (data.status === 'terlambat') {
                        badgeClass = 'bg-warning';
                        textClass = 'text-warning';
                    } else if (data.status === 'tidak_hadir') {
                        badgeClass = 'bg-danger';
                        textClass = 'text-danger';
                    }
                    
                    statusElement.innerHTML = `<span class="${textClass}">${statusText} - ${data.waktu_absen}</span>`;
                    buttonContainer.innerHTML = `<span class="badge ${badgeClass}">${statusText}</span>`;
                }
            })
            .catch(error => console.error('Error loading presensi status:', error));
    }

    function openQRScanner(sessionId) {
        currentSessionId = sessionId;
        $('#qrScannerModal').modal('show');
    }

    function onScanSuccess(decodedText, decodedResult) {
        console.log("✅ QR berhasil discan:", decodedText);
        console.log("📱 Decoded result:", decodedResult);
        
        // Stop scanner immediately
        if (html5QrcodeScanner) {
            html5QrcodeScanner.clear();
        }
        
        // Close modal
        $('#qrScannerModal').modal('hide');
        
        // Validate QR code
        fetch('/siswa/siswa/presensi/validate-qr', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ qr_code: decodedText })
        })
        .then(response => {
            console.log("📡 Response status:", response.status);
            return response.json();
        })
        .then(data => {
            console.log("📦 Response dari server:", data);
            if (data.valid) {
                performCheckIn(currentSessionId, 'qr', decodedText);
            } else {
                alert('QR Code tidak valid: ' + (data.message || 'QR Code tidak dikenali'));
            }
        })
        .catch(error => {
            console.error('❌ Error validating QR:', error);
            alert('Error validating QR code: ' + error.message);
        });
    }

    function onScanFailure(error) {
        // Hanya log error yang penting, abaikan error kecil dari scanner
        if (error && !error.includes('NotFoundException') && !error.includes('No MultiFormat Readers')) {
            console.log("⚠️ Scanner error:", error);
            
            // Update status if it's a significant error
            if (error.includes('Permission denied') || error.includes('NotAllowedError')) {
                document.getElementById('scanner-status').innerHTML = '<span class="text-danger"><i class="fas fa-ban"></i> Akses kamera ditolak. Silakan izinkan akses kamera.</span>';
            } else if (error.includes('NotFoundError') || error.includes('No camera found')) {
                document.getElementById('scanner-status').innerHTML = '<span class="text-danger"><i class="fas fa-video-slash"></i> Kamera tidak ditemukan.</span>';
            }
        }
    }

    function manualCheckIn(sessionId) {
        if (confirm('Konfirmasi kehadiran untuk sesi ini?')) {
            performCheckIn(sessionId, 'manual');
        }
    }

    function performCheckIn(sessionId, metode, qrCode = null) {
    const data = { session_id: sessionId, metode: metode };
    if (qrCode) data.qr_code = qrCode;

    fetch('/siswa/siswa/presensi/check-in', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const card = document.querySelector(`#status-${sessionId}`).closest('.card-body');
            const buttonContainer = card.querySelector('.d-flex div');
            const statusElement = document.getElementById(`status-${sessionId}`);

            let statusText = data.status_text || 'Hadir';
            let badgeClass = 'bg-success';
            let textClass = 'text-success';
            
            if (data.status === 'terlambat') {
                badgeClass = 'bg-warning';
                textClass = 'text-warning';
            } else if (data.status === 'tidak_hadir') {
                badgeClass = 'bg-danger';
                textClass = 'text-danger';
            }

            buttonContainer.innerHTML = `<span class="badge ${badgeClass}">${statusText}</span>`;
            const waktuAbsen = data.waktu_absen || new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
            statusElement.innerHTML = `<span class="${textClass}">${statusText} - ${waktuAbsen}</span>`;

            alert('✅ Absen berhasil! Status: ' + statusText);

            // 🔄 Tambahkan ini: refresh halaman setelah 1.5 detik
            setTimeout(() => {
                location.reload();
            }, 1000);

        } else {
            alert('Error: ' + (data.error || 'Terjadi kesalahan tidak diketahui'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat melakukan absen. Silakan coba lagi.');
    });
}


    // Handle modal events
    $('#qrScannerModal').on('hidden.bs.modal', function () {
        if (html5QrcodeScanner) {
            html5QrcodeScanner.clear();
            html5QrcodeScanner = null;
        }
    });
    
    // Handle modal shown event
    $('#qrScannerModal').on('shown.bs.modal', function () {
        // Update status
        document.getElementById('scanner-status').innerHTML = '<div class="spinner-border spinner-border-sm" role="status"></div> Menginisialisasi kamera...';
        
        // Small delay to ensure modal is fully rendered
        setTimeout(function() {
            if (html5QrcodeScanner) {
                html5QrcodeScanner.clear();
            }
            
            try {
                html5QrcodeScanner = new Html5QrcodeScanner(
                    "qr-reader",
                    { 
                        fps: 10, 
                        qrbox: { width: 300, height: 300 },
                        aspectRatio: 1.0
                    },
                    false
                );
                html5QrcodeScanner.render(onScanSuccess, onScanFailure);
                
                // Update status to ready
                document.getElementById('scanner-status').innerHTML = '<span class="text-success"><i class="fas fa-check-circle"></i> Kamera siap, arahkan ke QR Code</span>';
            } catch (error) {
                console.error('❌ Error initializing QR scanner:', error);
                document.getElementById('scanner-status').innerHTML = '<span class="text-danger"><i class="fas fa-exclamation-triangle"></i> Gagal menginisialisasi kamera</span>';
                alert('Gagal menginisialisasi kamera. Pastikan browser mendukung akses kamera dan izinkan akses kamera.');
            }
        }, 200);
    });
</script>

@endsection
