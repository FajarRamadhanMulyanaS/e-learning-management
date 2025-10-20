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
                            <th>#</th>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Scan QR Code</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <div id="qr-reader" class="qr-scanner"></div>
                <p class="mt-3 text-muted">Arahkan kamera ke QR Code untuk melakukan absen</p>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    let currentSessionId = null;
    let html5QrcodeScanner = null;

    // Load presensi status for active sessions
    @foreach($activeSessions as $session)
        loadPresensiStatus({{ $session->id }});
    @endforeach

    function loadPresensiStatus(sessionId) {
        fetch(`/siswa/presensi/status/${sessionId}`)
            .then(response => response.json())
            .then(data => {
                const statusElement = document.getElementById(`status-${sessionId}`);
                if (data.status === 'tidak_hadir') {
                    statusElement.innerHTML = '<span class="text-danger">Belum absen</span>';
                } else {
                    statusElement.innerHTML = `<span class="text-success">${data.status_text} - ${data.waktu_absen}</span>`;
                }
            })
            .catch(error => {
                console.error('Error loading presensi status:', error);
            });
    }

    function openQRScanner(sessionId) {
        currentSessionId = sessionId;
        $('#qrScannerModal').modal('show');
        
        // Initialize QR scanner
        html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader",
            { fps: 10, qrbox: { width: 250, height: 250 } },
            false
        );
        
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    }

    function onScanSuccess(decodedText, decodedResult) {
        // Validate QR code
        fetch('/siswa/presensi/validate-qr', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                qr_code: decodedText
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.valid) {
                // Perform check-in
                performCheckIn(currentSessionId, 'qr', decodedText);
            } else {
                alert('QR Code tidak valid: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error validating QR:', error);
            alert('Error validating QR code');
        });
        
        html5QrcodeScanner.clear();
        $('#qrScannerModal').modal('hide');
    }

    function onScanFailure(error) {
        // Handle scan failure
    }

    function manualCheckIn(sessionId) {
        if (confirm('Konfirmasi kehadiran untuk sesi ini?')) {
            performCheckIn(sessionId, 'manual');
        }
    }

    function performCheckIn(sessionId, metode, qrCode = null) {
        const data = {
            session_id: sessionId,
            metode: metode
        };
        
        if (qrCode) {
            data.qr_code = qrCode;
        }

        fetch('/siswa/presensi/check-in', {
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
                alert('Absen berhasil!');
                location.reload();
            } else {
                alert('Error: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat melakukan absen');
        });
    }

    // Clean up scanner when modal is hidden
    $('#qrScannerModal').on('hidden.bs.modal', function () {
        if (html5QrcodeScanner) {
            html5QrcodeScanner.clear();
        }
    });
</script>

@endsection
