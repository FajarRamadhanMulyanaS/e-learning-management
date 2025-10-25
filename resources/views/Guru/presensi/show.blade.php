@extends('layout2.app')
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

        /* QR Code dengan background biru */
        #qrcode-wrapper {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border-radius: 12px;
            padding: 15px;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
            transition: all 0.3s ease;
        }

        #qrcode-wrapper:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
        }

        #qrcode-wrapper img,
        #qrcode-wrapper canvas {
            background-color: #ffffff !important;
            border-radius: 8px;
            padding: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
    </style>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Detail Sesi Presensi</h3>
            <div>
                @if ($session->is_active && !$session->is_closed)
                    @if ($session->mode === 'qr')
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

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
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
                @if ($session->deskripsi)
                    <div class="mt-2">
                        <strong>Deskripsi:</strong><br>
                        {{ $session->deskripsi }}
                    </div>
                @endif
            </div>
        </div>

        <!-- QR Code Section -->
        @if ($session->mode === 'qr' && $session->qr_code)
            <div class="card mb-4 shadow-sm border-0">


                <div class="card-body d-flex flex-column align-items-center justify-content-center py-4">
                    <div id="qrcode-wrapper" class="p-3 bg-white shadow-sm rounded"
                        style="display: inline-block; transition: all 0.3s ease;">
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
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($session->presensiRecords as $index => $record)
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
                                <div class="status-buttons d-flex gap-2 justify-content-center">
                                  @foreach (['hadir' => 'green', 'sakit' => 'orange', 'izin' => 'blue', 'tidak_hadir' => 'red'] as $status => $color)
                                        <div class="status-circle {{ $record->status === $status ? 'active' : '' }}"
                                            data-status="{{ $status }}" data-id="{{ $record->id }}"
                                            style="background-color: {{ $record->status === $status ? $color : 'transparent' }};
                           border: 2px solid {{ $color }};
                           width: 25px; height: 25px; border-radius: 50%; cursor: pointer;">
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
.status-buttons .status-circle.active {
    box-shadow: 0 0 6px rgba(0,0,0,0.2);
}
.status-buttons .status-circle:hover {
    transform: scale(1.1);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const statusColors = {
        hadir: 'green',
        sakit: 'orange',
        izin: 'blue',
        tidak_hadir: 'red'
    };

    const statusTexts = {
        hadir: 'Hadir',
        sakit: 'Sakit',
        izin: 'Izin',
        tidak_hadir: 'Tidak Hadir'
    };

    document.querySelectorAll('.status-circle').forEach(circle => {
        circle.addEventListener('click', function() {
            const id = this.dataset.id;
            const status = this.dataset.status;
            const parent = this.closest('.status-buttons');
            const row = this.closest('tr');

            fetch(`/guru/presensi/update-status/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ status })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Reset semua lingkaran
                    parent.querySelectorAll('.status-circle').forEach(el => {
                        el.classList.remove('active');
                        el.style.backgroundColor = 'transparent';
                    });

                    // Lingkaran yang diklik jadi aktif
                    this.classList.add('active');
                    this.style.backgroundColor = statusColors[status];

                    // Update badge teks di kolom Status
                    const badge = row.querySelector('td:nth-child(3) .badge');
                    badge.textContent = statusTexts[status];

                    showToast('Status berhasil diperbarui!');
                } else {
                    alert(data.message || 'Gagal memperbarui status!');
                }
            })
            .catch(err => console.error(err));
        });
    });
});

function showToast(msg) {
    const toast = document.createElement('div');
    toast.textContent = msg;
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: #28a745;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        z-index: 9999;
        animation: fadeInOut 3s ease;
    `;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}
</script>

    @if ($session->mode === 'qr' && $session->qr_code)
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

                    // Tambahkan background biru ke QR code
                    const qrElement = qrContainer.querySelector('img') || qrContainer.querySelector('canvas');
                    if (qrElement) {
                        qrElement.style.backgroundColor = '#ffffff';
                        qrElement.style.padding = '10px';
                        qrElement.style.borderRadius = '8px';
                        qrElement.style.boxShadow = '0 2px 8px rgba(0, 0, 0, 0.1)';
                    }

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
                    // Show loading animation
                    const qrWrapper = document.getElementById('qrcode-wrapper');
                    const originalContent = qrWrapper.innerHTML;

                    qrWrapper.innerHTML = `
            <div class="d-flex flex-column align-items-center justify-content-center" style="height: 250px;">
                <div class="spinner-border text-light mb-3" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="text-light mb-0">Regenerating QR Code...</p>
            </div>
        `;

                    fetch('{{ route('guru.presensi.regenerate-qr', $session->id) }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                // Regenerate QR code dengan background biru
                                regenerateQRCode();
                            } else {
                                qrWrapper.innerHTML = originalContent;
                                alert('Gagal: ' + data.message);
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            qrWrapper.innerHTML = originalContent;
                            alert('Terjadi kesalahan saat regenerate QR Code');
                        });
                }
            }

            // Function to regenerate QR code with blue background
            function regenerateQRCode() {
                // Reload page to get updated QR code
                location.reload();
            }
            // Tombol download QR Code
            document.getElementById('downloadQR').addEventListener('click', function() {
                const qrCanvas = document.querySelector('#qrcode-wrapper img') || document.querySelector(
                    '#qrcode-wrapper canvas');
                if (!qrCanvas) {
                    alert('QR Code belum dibuat!');
                    return;
                }

                // Show loading state
                const downloadBtn = document.getElementById('downloadQR');
                const originalText = downloadBtn.innerHTML;
                downloadBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Preparing Download...';
                downloadBtn.disabled = true;

                // Create a new canvas with blue background
                const downloadCanvas = document.createElement('canvas');
                const ctx = downloadCanvas.getContext('2d');
                const size = 240; // Slightly larger to accommodate padding
                downloadCanvas.width = size;
                downloadCanvas.height = size;

                // Fill with blue background
                ctx.fillStyle = '#007bff';
                ctx.fillRect(0, 0, size, size);

                // Add gradient effect
                const gradient = ctx.createLinearGradient(0, 0, size, size);
                gradient.addColorStop(0, '#007bff');
                gradient.addColorStop(1, '#0056b3');
                ctx.fillStyle = gradient;
                ctx.fillRect(0, 0, size, size);

                // Draw QR code in the center with padding
                const qrSize = 220;
                const offset = (size - qrSize) / 2;

                // Add white background for QR code
                ctx.fillStyle = '#ffffff';
                ctx.fillRect(offset - 5, offset - 5, qrSize + 10, qrSize + 10);

                if (qrCanvas.tagName === 'IMG') {
                    ctx.drawImage(qrCanvas, offset, offset, qrSize, qrSize);
                } else {
                    // For canvas elements
                    ctx.drawImage(qrCanvas, offset, offset, qrSize, qrSize);
                }

                // Download the image
                const link = document.createElement('a');
                link.href = downloadCanvas.toDataURL('image/png');
                link.download = 'QR_Presensi_{{ $session->id }}_Blue.png';
                link.click();

                // Show success message
                setTimeout(() => {
                    // Create a toast notification instead of alert
                    const toast = document.createElement('div');
                    toast.className = 'toast-notification';
                    toast.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: #28a745;
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            z-index: 9999;
            animation: slideIn 0.3s ease;
        `;
                    toast.innerHTML =
                        '<i class="fas fa-check-circle"></i> QR Code dengan background biru berhasil didownload!';
                    document.body.appendChild(toast);

                    setTimeout(() => {
                        toast.remove();
                    }, 3000);
                }, 500);

                // Reset button state
                setTimeout(() => {
                    downloadBtn.innerHTML = originalText;
                    downloadBtn.disabled = false;
                }, 1000);
            });
        </script>


    @endif
@endsection
