@extends('layout_new.app')
@section('konten')

<div class="container mt-4">
    <h3>Dashboard Presensi</h3>

    <!-- Statistik Umum -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $stats['total_sessions'] }}</h4>
                            <p class="mb-0">Total Sesi</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-calendar fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $stats['active_sessions'] }}</h4>
                            <p class="mb-0">Sesi Aktif</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-play fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $stats['total_records'] }}</h4>
                            <p class="mb-0">Total Record</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-list fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $stats['hadir_today'] }}</h4>
                            <p class="mb-0">Hadir Hari Ini</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-check fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Utama -->
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-alt fa-3x text-primary mb-3"></i>
                    <h5>Manajemen Sesi</h5>
                    <p class="text-muted">Lihat dan kelola semua sesi presensi</p>
                    <a href="{{ route('admin.presensi.sessions') }}" class="btn btn-primary">
                        <i class="fas fa-eye"></i> Lihat Sesi
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-chart-bar fa-3x text-success mb-3"></i>
                    <h5>Laporan Presensi</h5>
                    <p class="text-muted">Lihat laporan dan statistik presensi</p>
                    <a href="{{ route('admin.presensi.reports') }}" class="btn btn-success">
                        <i class="fas fa-chart-line"></i> Lihat Laporan
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-download fa-3x text-info mb-3"></i>
                    <h5>Export Data</h5>
                    <p class="text-muted">Export data presensi ke Excel</p>
                    <button class="btn btn-info" onclick="exportData()">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Sesi Aktif Hari Ini -->
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-clock"></i> Sesi Aktif Hari Ini</h5>
        </div>
        <div class="card-body">
            <div id="active-sessions">
                <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Load active sessions
    function loadActiveSessions() {
        fetch('/admin/presensi/active-sessions')
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('active-sessions');
                
                if (data.length === 0) {
                    container.innerHTML = '<div class="text-center text-muted"><i class="fas fa-calendar-times fa-2x mb-2"></i><p>Tidak ada sesi aktif hari ini</p></div>';
                    return;
                }

                let html = '<div class="table-responsive"><table class="table table-striped"><thead><tr><th>Kelas</th><th>Mapel</th><th>Guru</th><th>Jam</th><th>Mode</th><th>Presensi</th></tr></thead><tbody>';
                
                data.forEach(session => {
                    html += `
                        <tr>
                            <td>${session.kelas.nama_kelas}</td>
                            <td>${session.mapel.nama_mapel}</td>
                            <td>${session.guru.username}</td>
                            <td>${session.jam_mulai_formatted}</td>
                            <td><span class="badge ${session.mode === 'qr' ? 'badge-info' : 'badge-warning'}">${session.mode.toUpperCase()}</span></td>
                            <td><a href="/admin/presensi/sessions/${session.id}" class="btn btn-sm btn-primary">Lihat</a></td>
                        </tr>
                    `;
                });
                
                html += '</tbody></table></div>';
                container.innerHTML = html;
            })
            .catch(error => {
                console.error('Error loading active sessions:', error);
                document.getElementById('active-sessions').innerHTML = '<div class="text-center text-danger">Error loading data</div>';
            });
    }

    // Export data function
    function exportData() {
        fetch('/admin/presensi/export-excel', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.blob())
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'presensi_data.xlsx';
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
            document.body.removeChild(a);
        })
        .catch(error => {
            console.error('Error exporting data:', error);
            alert('Error exporting data');
        });
    }

    // Load active sessions on page load
    loadActiveSessions();

    // Refresh every 30 seconds
    setInterval(loadActiveSessions, 30000);
</script>

@endsection
