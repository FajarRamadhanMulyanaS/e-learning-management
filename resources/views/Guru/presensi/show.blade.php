@extends('layout_new.app')
@section('konten')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Detail Sesi Presensi</h3>
        <div>
            @if($session->is_active && !$session->is_closed)
                @if($session->mode === 'qr')
                    <button type="button" class="btn btn-warning" onclick="regenerateQR()">
                        <i class="fas fa-sync"></i> Regenerate QR
                    </button>
                @endif
                <form action="{{ route('guru.presensi.close', $session->id) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Tutup sesi presensi ini?')">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times"></i> Tutup Sesi
                    </button>
                </form>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Info Sesi -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Informasi Sesi</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <strong>Tanggal:</strong><br>
                    {{ $session->tanggal->format('d F Y') }}
                </div>
                <div class="col-md-3">
                    <strong>Jam Mulai:</strong><br>
                    {{ $session->jam_mulai_formatted }}
                </div>
                <div class="col-md-3">
                    <strong>Kelas:</strong><br>
                    {{ $session->kelas->nama_kelas }}
                </div>
                <div class="col-md-3">
                    <strong>Mapel:</strong><br>
                    {{ $session->mapel->nama_mapel }}
                </div>
            </div>
            @if($session->deskripsi)
                <div class="mt-2">
                    <strong>Deskripsi:</strong><br>
                    {{ $session->deskripsi }}
                </div>
            @endif
        </div>
    </div>

    <!-- QR Code Section -->
    @if($session->mode === 'qr' && $session->qr_code)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">QR Code Presensi</h5>
            </div>
            <div class="card-body text-center">
                <div id="qrcode"></div>
                <p class="mt-2 text-muted">
                    QR Code berlaku hingga: {{ $session->qr_expires_at->format('H:i:s') }}
                </p>
                <p class="text-danger" id="qr-timer"></p>
            </div>
        </div>
    @endif

    <!-- Statistik Presensi -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Statistik Presensi</h5>
        </div>
        <div class="card-body">
            <div class="row text-center">
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h4>{{ $stats['hadir'] }}</h4>
                            <p class="mb-0">Hadir</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <h4>{{ $stats['terlambat'] }}</h4>
                            <p class="mb-0">Terlambat</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            <h4>{{ $stats['tidak_hadir'] }}</h4>
                            <p class="mb-0">Tidak Hadir</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <h4>{{ $stats['persentase_hadir'] }}%</h4>
                            <p class="mb-0">Kehadiran</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Siswa -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Daftar Siswa</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Status</th>
                            <th>Waktu Absen</th>
                            <th>Metode</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($session->presensiRecords as $index => $record)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $record->siswa->username }}</td>
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
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@if($session->mode === 'qr' && $session->qr_code)
<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>
<script>
    // Generate QR Code
    document.addEventListener('DOMContentLoaded', function() {
        const canvas = document.getElementById('qrcode');
        if (canvas) {
            QRCode.toCanvas(canvas, '{{ $session->qr_code }}', {
                width: 200,
                height: 200,
                color: {
                    dark: '#000000',
                    light: '#FFFFFF'
                }
            }, function (error) {
                if (error) {
                    console.error('Error generating QR code:', error);
                    canvas.innerHTML = '<p class="text-danger">Error generating QR code</p>';
                }
            });
        }
    });

    // QR Timer
    function updateQRTimer() {
        const expiresAt = new Date('{{ $session->qr_expires_at }}').getTime();
        const now = new Date().getTime();
        const timeLeft = expiresAt - now;

        if (timeLeft > 0) {
            const minutes = Math.floor(timeLeft / (1000 * 60));
            const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
            document.getElementById('qr-timer').textContent = 
                `Waktu tersisa: ${minutes}:${seconds.toString().padStart(2, '0')}`;
        } else {
            document.getElementById('qr-timer').textContent = 'QR Code sudah expired';
        }
    }

    updateQRTimer();
    setInterval(updateQRTimer, 1000);

    // Regenerate QR
    function regenerateQR() {
        if (confirm('Regenerate QR Code? QR Code lama akan tidak berlaku.')) {
            fetch('{{ route("guru.presensi.regenerate-qr", $session->id) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('QR Code berhasil diperbarui!');
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat regenerate QR Code');
            });
        }
    }
</script>
@endif

@endsection
