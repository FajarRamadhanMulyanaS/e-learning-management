@extends('layout_siswa.app')
@section('konten')
<style>
    body, h2, h1 {
        font-family: 'Times New Roman', Times, serif, sans-serif;
    }
    .ekskul-list {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: center;
        margin-top: 20px;
    }
    .ekskul-item {
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        transition: background-color 0.3s;
    }
    .ekskul-item:hover {
        background-color: #f0f0f0;
    }
    #myBtn {
        display: none;
        position: fixed;
        bottom: 20px;
        right: 30px;
        z-index: 99;
        font-size: 18px;
        border: none;
        outline: none;
        background-color: #555;
        color: white;
        cursor: pointer;
        padding: 15px;
        border-radius: 4px;
    }
    #myBtn:hover {
        background-color: #333;
    }

    /* ========== STRUKTUR MATA PELAJARAN STYLE ========== */
    .jurusan-section {
        margin-top: 60px;
    }
    .jurusan-header {
        text-align: center;
        margin-bottom: 40px;
    }
    .jurusan-card {
        display: flex;
        align-items: center;
        gap: 30px;
        background: #fff;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        margin-bottom: 40px;
        transition: transform 0.3s ease;
    }
    .jurusan-card:hover {
        transform: translateY(-5px);
    }
    .jurusan-card img {
        width: 350px;
        height: 220px;
        object-fit: cover;
        border-radius: 12px;
    }
    .jurusan-content h4 {
        color: #007bff;
        font-weight: bold;
    }
    .jurusan-content p {
        font-size: 15px;
        color: #555;
    }
    .mapel-list {
        margin-top: 10px;
        font-size: 15px;
    }
    .mapel-list strong {
        color: #333;
    }
    .semester-title {
        font-weight: bold;
        color: #007bff;
        margin-top: 10px;
    }
</style>

<title>Dashboard</title>

<body>
<!-- Tombol Go to Top -->
<button onclick="topFunction()" id="myBtn" title="Go to top"><i class="fas fa-arrow-up"></i></button>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 text-center text-primary">Home Page</h1>
            <hr>

            {{-- ====================== JADWAL HARI INI ====================== --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fa-solid fa-calendar-day"></i> Jadwal Pelajaran Hari Ini ({{ $hariIni }})</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Hari</th>
                                <th>Jam</th>
                                <th>Mata Pelajaran</th>
                                <th>Pengajar</th>
                                <th>Ruang</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jadwalHariIni as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->hari }}</td>
                                    <td>
                                        {{ optional(\Carbon\Carbon::parse($item->jam_mulai))->format('H:i') }} -
                                        {{ optional(\Carbon\Carbon::parse($item->jam_selesai))->format('H:i') }}
                                    </td>
                                    <td>{{ optional($item->mapel)->nama_mapel ?? '-' }}</td>
                                    <td>{{ optional($item->user)->username ?? '-' }}</td>
                                    <td>{{ $item->ruang ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Tidak ada jadwal untuk hari {{ $hariIni }}.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ====================== STRUKTUR MATA PELAJARAN ====================== --}}
            <div class="jurusan-section">
                <div class="jurusan-header">
                    <h2 class="text-primary"><i class="fa-solid fa-book-open-reader"></i> Struktur Mata Pelajaran per Jurusan</h2>
                    <p class="text-muted">Pelajari struktur pembelajaran berdasarkan jurusan untuk memahami kompetensi yang dikembangkan pada setiap semester.</p>
                </div>

                {{-- Administrasi Bisnis --}}
                <div class="jurusan-card">
                    <img src="https://img.freepik.com/free-photo/business-meeting-office_155003-4211.jpg" alt="Administrasi Bisnis">
                    <div class="jurusan-content">
                        <h4>Administrasi Bisnis</h4>
                        <p>Jurusan ini berfokus pada keterampilan administrasi modern, komunikasi bisnis, dan penggunaan perangkat lunak perkantoran yang mendukung efisiensi kerja di dunia usaha.</p>

                        <div class="semester-title">Semester 1</div>
                        <div class="mapel-list">
                            1. Typing (Mengetik 10 jari) I<br>
                            2. Microsoft Word<br>
                            3. Microsoft Excel<br>
                            4. Koresponden Bisnis<br>
                            5. Manajemen Perkantoran<br>
                            6. English Conversation I<br>
                            7. English Conversation II<br>
                            8. Photoshop
                        </div>

                        <div class="semester-title">Semester 2</div>
                        <div class="mapel-list">
                            1. Typing (Mengetik 10 jari) II<br>
                            2. Corel Draw<br>
                            3. Power Point<br>
                            4. Pemasaran (Marketing)<br>
                            5. Etika Perkantoran<br>
                            6. English Conversation III<br>
                            7. English Conversation IV<br>
                            8. Magang (JOB TRAINING)
                        </div>
                    </div>
                </div>

                {{-- Akuntansi Komputer --}}
                <div class="jurusan-card">
                    <img src="https://img.freepik.com/free-photo/close-up-hand-calculating-bills_1098-20227.jpg" alt="Akuntansi Komputer">
                    <div class="jurusan-content">
                        <h4>Akuntansi Komputer</h4>
                        <p>Jurusan ini menggabungkan ilmu akuntansi dengan teknologi komputer untuk mengelola data keuangan secara cepat, akurat, dan modern menggunakan berbagai software akuntansi.</p>

                        <div class="semester-title">Semester 1</div>
                        <div class="mapel-list">
                            1. Typing (Mengetik 10 jari) I<br>
                            2. Microsoft Word<br>
                            3. Microsoft Excel<br>
                            4. Akuntansi Dasar I<br>
                            5. Akuntansi Dasar II<br>
                            6. English Conversation I<br>
                            7. English Conversation II
                        </div>

                        <div class="semester-title">Semester 2</div>
                        <div class="mapel-list">
                            1. Typing (Mengetik 10 jari) II<br>
                            2. Power Point<br>
                            3. Akuntansi Biaya<br>
                            4. Akuntansi Komputer<br>
                            5. English Conversation III<br>
                            6. English Conversation IV<br>
                            7. Magang (JOB TRAINING)
                        </div>
                    </div>
                </div>

                {{-- Desain Grafis --}}
                <div class="jurusan-card">
                    <img src="https://img.freepik.com/free-photo/graphic-designer-working-modern-office_155003-10268.jpg" alt="Desain Grafis">
                    <div class="jurusan-content">
                        <h4>Desain Grafis</h4>
                        <p>Jurusan ini melatih kreativitas dalam menciptakan karya visual digital menggunakan perangkat lunak desain, serta mengasah kemampuan komunikasi visual profesional.</p>

                        <div class="semester-title">Semester 1</div>
                        <div class="mapel-list">
                            1. Typing (Mengetik 10 jari) I<br>
                            2. Microsoft Word<br>
                            3. Microsoft Excel<br>
                            4. Corel Draw<br>
                            5. English Conversation I<br>
                            6. English Conversation II
                        </div>

                        <div class="semester-title">Semester 2</div>
                        <div class="mapel-list">
                            1. Typing (Mengetik 10 jari) II<br>
                            2. Power Point<br>
                            3. Photoshop<br>
                            4. English Conversation III<br>
                            5. English Conversation IV<br>
                            6. Magang (JOB TRAINING)
                        </div>
                    </div>
                </div>
            </div>
            {{-- ====================== END STRUKTUR MATA PELAJARAN ====================== --}}

        </div>
    </main>
</div>

<script>
    // Tombol scroll ke atas
    window.onscroll = function() { scrollFunction() };
    function scrollFunction() {
        if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
            document.getElementById("myBtn").style.display = "block";
        } else {
            document.getElementById("myBtn").style.display = "none";
        }
    }
    function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }
</script>
</body>
@endsection
