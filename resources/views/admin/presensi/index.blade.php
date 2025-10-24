@extends('layout_new.app')
@section('konten')

<style>
    body {
        font-family: 'Poppins', sans-serif;
    }

    h3 {
        font-weight: 600;
        color: #333;
    }

    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 14px rgba(0, 0, 0, 0.12);
    }

    .card-body i {
        opacity: 0.8;
    }

    .card h4 {
        font-weight: bold;
        font-size: 1.8rem;
    }

    .card p {
        font-size: 0.9rem;
        margin-bottom: 0;
    }

    .menu-card {
        transition: all 0.3s ease;
    }

    .menu-card:hover {
        background-color: #f8f9fa;
        transform: translateY(-4px);
    }

    .menu-card i {
        transition: transform 0.3s;
    }

    .menu-card:hover i {
        transform: scale(1.1);
    }

    .card-header {
        background-color: #f8f9fa;
        border-bottom: none;
        font-weight: 600;
        color: #444;
    }

    .table th {
        background-color: #f1f3f5;
    }

    .btn {
        border-radius: 8px;
    }

    .badge {
        font-size: 0.8rem;
        padding: 6px 10px;
        border-radius: 10px;
    }

    .badge-info {
        background-color: #17a2b8;
    }

    .badge-warning {
        background-color: #ffc107;
    }
</style>

<div class="container mt-4">
    <h3 class="mb-4"><i class="fas fa-home"></i> Dashboard Presensi</h3>

    <!-- Statistik Umum -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4>{{ $stats['total_sessions'] }}</h4>
                            <p>Total Sesi</p>
                        </div>
                        <i class="fas fa-calendar fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4>{{ $stats['active_sessions'] }}</h4>
                            <p>Sesi Aktif</p>
                        </div>
                        <i class="fas fa-play fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4>{{ $stats['total_records'] }}</h4>
                            <p>Total Record</p>
                        </div>
                        <i class="fas fa-list fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4>{{ $stats['hadir_today'] }}</h4>
                            <p>Hadir Hari Ini</p>
                        </div>
                        <i class="fas fa-check fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Utama -->
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card menu-card h-100 text-center p-4">
                <i class="fas fa-calendar-alt fa-3x text-primary mb-3"></i>
                <h5 class="fw-bold">Manajemen Sesi</h5>
                <p class="text-muted mb-3">Lihat dan kelola semua sesi presensi dengan mudah dan cepat.</p>
                <a href="{{ route('admin.presensi.sessions') }}" class="btn btn-primary px-4">
                    <i class="fas fa-eye"></i> Lihat Sesi
                </a>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card menu-card h-100 text-center p-4">
                <i class="fas fa-chart-bar fa-3x text-success mb-3"></i>
                <h5 class="fw-bold">Laporan Presensi</h5>
                <p class="text-muted mb-3">Lihat laporan dan statistik presensi secara detail.</p>
                <a href="{{ route('admin.presensi.reports') }}" class="btn btn-success px-4">
                    <i class="fas fa-chart-line"></i> Lihat Laporan
                </a>
            </div>
        </div>
    </div>

    <!-- Sesi Aktif Hari Ini -->
    <div class="card mt-4">
        <div class="card-header">
            <i class="fas fa-clock"></i> Sesi Aktif Hari Ini
        </div>
        <div class="card-body">
            <div id="active-sessions">
                <div class="text-center py-3">
                    <div class="spinner-border" role="status"></div>
                    <p class="text-muted mt-2">Memuat data sesi aktif...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function loadActiveSessions() {
        fetch('/admin/presensi/active-sessions')
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('active-sessions');

                if (data.length === 0) {
                    container.innerHTML = `
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-calendar-times fa-2x mb-2"></i>
                            <p>Tidak ada sesi aktif hari ini</p>
                        </div>`;
                    return;
                }

                let html = `
                    <div class="table-responsive">
                        <table class="table table-striped align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>Kelas</th>
                                    <th>Mapel</th>
                                    <th>Guru</th>
                                    <th>Jam</th>
                                    <th>Mode</th>
                                    <th>Presensi</th>
                                </tr>
                            </thead>
                            <tbody>`;

                data.forEach(session => {
                    html += `
                        <tr>
                            <td>${session.kelas.nama_kelas}</td>
                            <td>${session.mapel.nama_mapel}</td>
                            <td>${session.guru.username}</td>
                            <td>${session.jam_mulai_formatted}</td>
                            <td><span class="badge ${session.mode === 'qr' ? 'badge-info' : 'badge-warning'}">${session.mode.toUpperCase()}</span></td>
                            <td><a href="/admin/presensi/sessions/${session.id}" class="btn btn-sm btn-primary">Lihat</a></td>
                        </tr>`;
                });

                html += '</tbody></table></div>';
                container.innerHTML = html;
            })
            .catch(error => {
                console.error('Error loading active sessions:', error);
                document.getElementById('active-sessions').innerHTML = `
                    <div class="text-center text-danger py-3">Gagal memuat data sesi aktif.</div>`;
            });
    }

    loadActiveSessions();
    setInterval(loadActiveSessions, 30000);
</script>

@endsection
