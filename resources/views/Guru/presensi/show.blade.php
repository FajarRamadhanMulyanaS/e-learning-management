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

    .modal-qr {
    display: none; /* default disembunyikan */
    justify-content: center;
    align-items: center;
    position: fixed;
    z-index: 1000;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.85);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.modal-qr.show {
    display: flex; /* muncul saat class show ditambahkan */
    opacity: 1;
}

/* Ukuran QR di modal */
.modal-qr canvas {
    width: 450px;        /* ubah ukuran sesuai kebutuhan */
    height: 450px;       /* pastikan sama agar proporsional */
    max-width: 90vw;     /* tetap responsif di layar kecil */
    max-height: 90vh;
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 0 25px rgba(0, 0, 0, 0.5);
    transform: scale(1);
    transition: transform 0.3s ease;
}

/* Efek zoom-in halus saat muncul */
.modal-qr.show canvas {
    transform: scale(1.1);
}

.modal-close {
    position: absolute;
    top: 20px;
    right: 30px;
    font-size: 2rem;
    color: white;
    cursor: pointer;
    font-weight: bold;
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

        @if ($session->mode === 'qr' && $session->qr_code)
            <div class="card mb-4 shadow-sm border-0">
                <!-- Modal QR -->
                <div class="modal-qr" id="qrModal" onclick="closeQRModal(event)">
                    <span class="modal-close" onclick="closeQRModal(event)">&times;</span>
                    <canvas id="qrcodeModal"></canvas>
                </div>

                <div class="card-body d-flex flex-column align-items-center justify-content-center py-4">
                    <div id="qrcode-wrapper" class="p-3 bg-white shadow-sm rounded cursor-pointer"
                        style="display: inline-block; transition: all 0.3s ease; cursor: pointer;" onclick="openQRModal()">
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

    {{-- ========================================================== --}}
    {{-- ========== BLOK STATISTIK PRESENSI DIPERBARUI ========== --}}
    {{-- ========================================================== --}}
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Statistik Presensi</h5>
        </div>
        <div class="card-body">
            <div class="row text-center">
                <div class="col-lg-2 col-md-4 col-6 mb-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h4 id="stats-hadir">{{ $stats['hadir'] ?? 0 }}</h4>
                            <p class="mb-0">Hadir</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-6 mb-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <h4 id="stats-terlambat">{{ $stats['terlambat'] ?? 0 }}</h4>
                            <p class="mb-0">Terlambat</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-4 col-6 mb-3">
                    <div class="card bg-warning text-dark">
                        <div class="card-body">
                            <h4 id="stats-sakit">{{ $stats['sakit'] ?? 0 }}</h4>
                            <p class="mb-0">Sakit</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-4 col-6 mb-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <h4 id="stats-izin">{{ $stats['izin'] ?? 0 }}</h4>
                            <p class="mb-0">Izin</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-4 col-6 mb-3">
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            {{-- [PERBAIKAN] Menggunakan $stats['alpa'] dari model --}}
                            <h4 id="stats-alpa">{{ $stats['alpa'] ?? 0 }}</h4>
                            <p class="mb-0">Alpa</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-4 col-6 mb-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h4 id="stats-persentase">{{ $stats['persentase_hadir'] ?? 0 }}%</h4>
                            <p class="mb-0">Kehadiran</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- ========================================================== --}}
    {{--               AKHIR BLOK STATISTIK DIPERBARUI                --}}
    {{-- ========================================================== --}}


    <div class="d-flex justify-content-center mt-4">
        <div class="card shadow-lg" style="width: 90%; max-width: 1000px;">
            <div class="card-header text-center bg-primary text-white">
                <h5 class="mb-0">Daftar Siswa</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive text-center">
                    <table class="table table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>Status</th>
                                <th>Waktu Absen</th>
                                <th>Aksi</th>
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
                                    <td class="text-center">
                                        <div class="status-labels d-flex gap-3 justify-content-center mb-1">
                                            <small class="text-success fw-semibold">Hadir</small>
                                            <small class="text-info fw-semibold">Izin</small>
                                            <small class="text-warning fw-semibold">Sakit</small>
                                            <small class="text-danger fw-semibold">Alpa</small>
                                        </div>

                                        <div class="status-buttons d-flex gap-3 justify-content-center">
                                            @foreach (['hadir' => 'green', 'izin' => 'blue', 'sakit' => 'orange', 'tidak_hadir' => 'red'] as $status => $color)
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
    </div>


    <style>
        .status-buttons .status-circle.active {
            box-shadow: 0 0 6px rgba(0, 0, 0, 0.2);
        }

        .status-buttons .status-circle:hover {
            transform: scale(1.1);
        }

        .status-labels small {
            font-size: 12px;
            display: inline-block;
            width: 40px;
            text-align: center;
        }
    </style>

    <script>
        function openQRModal() {
            const modal = document.getElementById('qrModal');
            const qrModalCanvas = document.getElementById('qrcodeModal');

            // Cari elemen QR di wrapper (bisa IMG atau CANVAS)
            const qrElement = document.querySelector(
                '#qrcode-wrapper img, #qrcode-wrapper canvas, #qrcode-wrapper #qrcode');
            if (!qrElement) return;

            const ctx = qrModalCanvas.getContext('2d');
            const img = new Image();
            img.crossOrigin = 'anonymous';

            // Dapatkan data URL dari elemen QR
            if (qrElement.tagName === 'IMG') {
                img.src = qrElement.src;
            } else if (qrElement.tagName === 'CANVAS') {
                img.src = qrElement.toDataURL('image/png');
            } else {
                // fallback jika ada elemen lain
                img.src = qrElement.getAttribute('src') || '';
            }

            img.onload = function() {
                // skala supaya tidak melebihi layar
                const maxSize = Math.min(window.innerWidth * 0.9, window.innerHeight * 0.9);
                let w = img.width;
                let h = img.height;
                const ratio = Math.min(maxSize / w, maxSize / h, 1);
                qrModalCanvas.width = Math.round(w * ratio);
                qrModalCanvas.height = Math.round(h * ratio);
                ctx.clearRect(0, 0, qrModalCanvas.width, qrModalCanvas.height);
                ctx.drawImage(img, 0, 0, qrModalCanvas.width, qrModalCanvas.height);
            };

            modal.classList.add('show');
        }

        function closeQRModal(event) {
            const modal = document.getElementById('qrModal');
            // Tutup modal hanya jika klik di luar QR atau tombol close
            if (event.target.classList.contains('modal-qr') || event.target.classList.contains('modal-close')) {
                modal.classList.remove('show');
            }
        }
    </script>

    {{-- =============================================== --}}
    {{-- ========== BLOK SCRIPT (SUDAH FINAL) ========== --}}
    {{-- =============================================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Peta untuk warna lingkaran aksi
            const statusColors = {
                hadir: 'green',
                sakit: 'orange',
                izin: 'blue',
                tidak_hadir: 'red'
            };

            // Peta untuk teks di kolom status tabel
            const statusTexts = {
                hadir: 'Hadir',
                sakit: 'Sakit',
                izin: 'Izin',
                tidak_hadir: 'Tidak Hadir' // Teks di tabel
            };

            // Peta untuk kelas badge Bootstrap di tabel
            const statusBadgeClasses = {
                hadir: 'bg-success',
                sakit: 'bg-warning',
                izin: 'bg-info',
                tidak_hadir: 'bg-danger', // 'Tidak Hadir' di tabel -> badge merah
                terlambat: 'bg-warning'
            };

            // Fungsi untuk update statistik di card atas
            function updateStats() {
                let hadirCount = 0;
                let sakitCount = 0;
                let izinCount = 0;
                let alpaCount = 0;

                // Ambil 'terlambat' dari DOM, karena tidak diatur manual
                const terlambatCount = parseInt(document.getElementById('stats-terlambat').textContent) || 0;

                const rows = document.querySelectorAll('tbody tr');
                const totalSiswa = rows.length;

                rows.forEach(row => {
                    const badge = row.querySelector('td:nth-child(3) .badge');
                    if (!badge) return;

                    const statusText = badge.textContent.trim();

                    // Memecah perhitungan berdasarkan teks di badge
                    if (statusText === 'Hadir') {
                        hadirCount++;
                    } else if (statusText === 'Sakit') {
                        sakitCount++;
                    } else if (statusText === 'Izin') {
                        izinCount++;
                    } else if (statusText ===
                        'Tidak Hadir') { // Teks "Tidak Hadir" di tabel dihitung sebagai Alpa
                        alpaCount++;
                    }
                    // Status 'Terlambat' sudah dihitung di awal
                });

                // Hitung ulang persentase
                const totalHadirDanTerlambat = hadirCount + terlambatCount;
                const persentase = (totalSiswa > 0) ? Math.round((totalHadirDanTerlambat / totalSiswa) * 100) : 0;

                // Update angka di DOM
                document.getElementById('stats-hadir').textContent = hadirCount;
                document.getElementById('stats-sakit').textContent = sakitCount;
                document.getElementById('stats-izin').textContent = izinCount;
                document.getElementById('stats-alpa').textContent = alpaCount;
                document.getElementById('stats-persentase').textContent = persentase + '%';
            }


            // Event listener untuk lingkaran aksi
            document.querySelectorAll('.status-circle').forEach(circle => {
                circle.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const status = this.dataset.status;
                    const parent = this.closest('.status-buttons');
                    const row = this.closest('tr');

                    if (this.classList.contains('active')) {
                        return;
                    }

                    fetch(`/guru/presensi/update-status/${id}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                status
                            })
                        })
                        .then(res => {
                            if (!res.ok) {
                                throw new Error(`HTTP error! status: ${res.status}`);
                            }
                            return res.json();
                        })
                        .then(data => {
                            if (data.success) {
                                // 1. Reset lingkaran
                                parent.querySelectorAll('.status-circle').forEach(el => {
                                    el.classList.remove('active');
                                    el.style.backgroundColor = 'transparent';
                                });

                                // 2. Aktifkan lingkaran
                                this.classList.add('active');
                                this.style.backgroundColor = statusColors[status];

                                // 3. Update badge status di tabel
                                const badge = row.querySelector('td:nth-child(3) .badge');

                                badge.textContent = statusTexts[status];
                                badge.className = 'badge';
                                badge.classList.add(statusBadgeClasses[status]);

                                // 4. Panggil fungsi update statistik
                                updateStats();

                                showToast('Status berhasil diperbarui!');
                            } else {
                                alert(data.message || 'Gagal memperbarui status!');
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            alert(
                                'Terjadi kesalahan. Cek konsol (F12) untuk detail. Pastikan rute dan controller sudah benar.'
                            );
                        });
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
            const styleSheet = document.createElement("style");
            styleSheet.type = "text/css";
            styleSheet.innerText = `
        @keyframes fadeInOut {
            0%, 100% { opacity: 0; transform: translateY(-20px); }
            10%, 90% { opacity: 1; transform: translateY(0); }
        }
    `;
            document.head.appendChild(styleSheet);

            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 3000);
        }
    </script>
    {{-- =============================================== --}}
    {{--        AKHIR BLOK SCRIPT DIPERBARUI         --}}
    {{-- =============================================== --}}


    @if ($session->mode === 'qr' && $session->qr_code)
        <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

        <script>
            // ... (Kode JavaScript untuk QR Code, Regenerate, dan Download) ...
            // ... (Tidak ada perubahan di sini) ...
            document.addEventListener('DOMContentLoaded', function() {
                const canvas = document.getElementById('qrcode');
                const qrData = @json($session->qr_code);

                console.log('QR Data:', qrData);

                if (canvas && qrData) {
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

                    const qrElement = qrContainer.querySelector('img') || qrContainer.querySelector('canvas');
                    if (qrElement) {
                        // Pastikan terlihat seperti tombol dan bisa diklik untuk membuka modal
                        qrElement.id = 'qrcode';
                        qrElement.style.cursor = 'pointer';
                        qrElement.style.backgroundColor = '#ffffff';
                        qrElement.style.padding = '10px';
                        qrElement.style.borderRadius = '8px';
                        qrElement.style.boxShadow = '0 2px 8px rgba(0, 0, 0, 0.1)';
                        qrElement.addEventListener('click', openQRModal);
                    }

                    console.log('QR Code berhasil dibuat.');
                } else {
                    console.warn('Canvas tidak ditemukan atau data QR kosong.');
                }

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

            function regenerateQR() {
                if (confirm('Regenerate QR Code? QR Code lama akan tidak berlaku.')) {
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

            function regenerateQRCode() {
                location.reload();
            }
            document.getElementById('downloadQR').addEventListener('click', function() {
                const qrCanvas = document.querySelector('#qrcode-wrapper img') || document.querySelector(
                    '#qrcode-wrapper canvas');
                if (!qrCanvas) {
                    alert('QR Code belum dibuat!');
                    return;
                }

                const downloadBtn = document.getElementById('downloadQR');
                const originalText = downloadBtn.innerHTML;
                downloadBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Preparing Download...';
                downloadBtn.disabled = true;

                const downloadCanvas = document.createElement('canvas');
                const ctx = downloadCanvas.getContext('2d');
                const size = 240;
                downloadCanvas.width = size;
                downloadCanvas.height = size;

                ctx.fillStyle = '#007bff';
                ctx.fillRect(0, 0, size, size);

                const gradient = ctx.createLinearGradient(0, 0, size, size);
                gradient.addColorStop(0, '#007bff');
                gradient.addColorStop(1, '#0056b3');
                ctx.fillStyle = gradient;
                ctx.fillRect(0, 0, size, size);

                const qrSize = 220;
                const offset = (size - qrSize) / 2;

                ctx.fillStyle = '#ffffff';
                ctx.fillRect(offset - 5, offset - 5, qrSize + 10, qrSize + 10);

                if (qrCanvas.tagName === 'IMG') {
                    ctx.drawImage(qrCanvas, offset, offset, qrSize, qrSize);
                } else {
                    ctx.drawImage(qrCanvas, offset, offset, qrSize, qrSize);
                }

                const link = document.createElement('a');
                link.href = downloadCanvas.toDataURL('image/png');
                link.download = 'QR_Presensi_{{ $session->id }}_Blue.png';
                link.click();

                setTimeout(() => {
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

                setTimeout(() => {
                    downloadBtn.innerHTML = originalText;
                    downloadBtn.disabled = false;
                }, 1000);
            });
        </script>
    @endif
@endsection
