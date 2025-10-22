@extends('layout_new.app')
@section('konten')
<style>
#qrcode-wrapper {
    animation: fadeIn 0.6s ease-in-out;
}

#qrcode-wrapper img {
    border-radius: 10px;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.95);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

#qr-timer {
    font-size: 16px;
    margin-top: 5px;
}
</style>

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
<div class="card mb-4 shadow-sm border-0">
   

    <div class="card-body d-flex flex-column align-items-center justify-content-center py-4">
        <div id="qrcode-wrapper" class="p-3 bg-white shadow-sm rounded" style="display: inline-block; transition: all 0.3s ease;">
            <canvas id="qrcode"></canvas>
       <button class="btn btn-outline-primary mt-3" id="downloadQR">
    <i class="fas fa-download"></i> Download QR Code
</button>


    </div>
        </div>

        <p class="mt-3 mb-1 text-muted">
            <i class="fas fa-clock"></i>
            Berlaku hingga: <strong>{{ $session->qr_expires_at->format('H:i:s') }}</strong>
        </p>
        <p class="text-danger fw-bold" id="qr-timer"></p>
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
<!-- Pastikan load library QRCode dari CDN yang pasti bekerja -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('qrcode');
    const qrData = @json($session->qr_code);

    console.log('QR Data:', qrData);

    if (canvas && qrData) {
        // Gunakan library qrcodejs (bukan yang versi node)
        const qrContainer = document.createElement('div');
        canvas.replaceWith(qrContainer);

        new QRCode(qrContainer, {
            text: qrData,
            width: 220,
            height: 220,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });

        console.log('QR Code berhasil dibuat.');
    } else {
        console.warn('Canvas tidak ditemukan atau data QR kosong.');
    }

    // Timer hitung waktu tersisa
    function updateQRTimer() {
        const expiresAt = new Date('{{ $session->qr_expires_at }}').getTime();
        const now = new Date().getTime();
        const timeLeft = expiresAt - now;

        const timerEl = document.getElementById('qr-timer');
        if (!timerEl) return;

        if (timeLeft > 0) {
            const minutes = Math.floor(timeLeft / 60000);
            const seconds = Math.floor((timeLeft % 60000) / 1000);
            timerEl.textContent = `Waktu tersisa: ${minutes}:${seconds.toString().padStart(2, '0')}`;
        } else {
            timerEl.textContent = 'QR Code sudah expired';
            timerEl.style.color = 'gray';
        }
    }

    updateQRTimer();
    setInterval(updateQRTimer, 1000);
});

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
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('QR Code berhasil diperbarui!');
                location.reload();
            } else {
                alert('Gagal: ' + data.message);
            }
        })
        .catch(err => {
            console.error(err);
            alert('Terjadi kesalahan saat regenerate QR Code');
        });
    }
}
// Tombol download QR Code
document.getElementById('downloadQR').addEventListener('click', function() {
    const qrCanvas = document.querySelector('#qrcode-wrapper img') || document.querySelector('#qrcode-wrapper canvas');
    if (!qrCanvas) {
        alert('QR Code belum dibuat!');
        return;
    }

    const link = document.createElement('a');
    link.href = qrCanvas.src || qrCanvas.toDataURL('image/png');
    link.download = 'QR_Presensi_{{ $session->id }}.png';
    link.click();
});

</script>
@endif




@endsection
