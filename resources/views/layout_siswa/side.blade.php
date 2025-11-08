<style>
    /* --- Sidebar tetap fixed dan bisa discroll --- */
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: 240px;
        /* sesuaikan dengan lebar sidebar sebelumnya */
        display: flex;
        flex-direction: column;
        z-index: 1000;
    }

    /* agar konten utama tidak tertutup sidebar */
    .main-panel {
        margin-left: 240px;
        /* samakan dengan lebar sidebar */
        width: calc(100% - 240px);
    }

    /* header profil tetap di atas sidebar */

    /* === PROFIL PENGGUNA DI SIDEBAR === */
    .user-profile {
        margin-top: 80px;
        /* ubah angka ini untuk jarak dari atas */
        padding: 35px;
        text-align: center;
        border-bottom: 1px solid #eee;
    }

    /* daftar menu bisa discroll */
    .sidebar .nav {
        flex: 1;
        overflow-y: auto;
        overflow-x: hidden;
    }

    /* scrollbar halus */
    .sidebar .nav::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar .nav::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0.2);
        border-radius: 3px;
    }

    .sidebar .nav::-webkit-scrollbar-thumb:hover {
        background-color: rgba(0, 0, 0, 0.3);
    }

    /* responsif untuk layar kecil */
    @media (max-width: 992px) {
        .sidebar {
            width: 220px;
        }

        .main-panel {
            margin-left: 220px;
            width: calc(100% - 220px);
        }
    }
</style>

<div class="container-fluid page-body-wrapper">

    <nav class="sidebar sidebar-offcanvas" id="sidebar">



        @if (auth()->user()->isGuru())
            <div class="user-profile">
                <div class="user-image">
                    <img src="{{ auth()->user()->foto ? asset('images/profil_guru/' . auth()->user()->foto) : asset('images/default.png') }}"
                        alt="User Profile Picture">
                </div>
                <div class="user-name">
                    {{ auth()->user()->username }}
                </div>
                <div class="user-designation">
                    {{ auth()->user()->role }}
                </div>
            </div>
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('guru.index') }}">
                        <i class="icon-box menu-icon"></i>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('auth.change-password') }}">
                        <i class="mdi mdi-key-variant menu-icon"></i>
                        <span class="menu-title">Ganti Password</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('guru.daftar_siswa') }}">
                        <i class="mdi mdi-account-multiple menu-icon"></i>
                        <span class="menu-title">Daftar Siswa</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('guru.manajemen-ujian.index') }}">
                        <i class="mdi mdi-file-document-edit menu-icon"></i>
                        <span class="menu-title">Management Ujian</span>
                    </a>
                </li>
                {{-- Menu Kuis Baru Ditambahkan Di Sini --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('guru.quiz.index') }}">
                        <i class="mdi mdi-puzzle menu-icon"></i>
                        <span class="menu-title">Manajemen Kuis</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('guru.materi.index') }}">
                        <i class="icon-paper menu-icon"></i>
                        <span class="menu-title">Management Materi</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('guru.video.index') }}">
                        <i class="mdi mdi-laptop-account menu-icon"></i>
                        <span class="menu-title">Management Video</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('guru.tugas-siswa.index') }}">
                        <i class="mdi mdi-book-outline menu-icon"></i>
                        <span class="menu-title">Tugas Siswa</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('guru.presensi.index') }}">
                        <i class="mdi mdi-clipboard-check menu-icon"></i>
                        <span class="menu-title">Presensi Online</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false"
                        aria-controls="auth">
                        <i class="icon-head menu-icon"></i>
                        <span class="menu-title">User Pages</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="auth">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('guru.profil.profil_guru') }}"> Profil </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('auth.change-password') }}"> Ganti Password </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#pesan" aria-expanded="false"
                        aria-controls="pesan">
                        <i class="mdi mdi-email-outline menu-icon"></i>
                        <span class="menu-title">Kotak Pesan</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="pesan">
                        <ul class="nav flex-column sub-menu">

                            <li class="nav-item"> <a class="nav-link" href="{{ route('guru.pesan.index') }}"> Pesan
                                    Masuk </a></li>
                            <li class="nav-item"> <a class="nav-link" href="{{ route('guru.pesan.pengirim') }}"> Pesan
                                    Dikirim </a></li>
                            <li class="nav-item"> <a class="nav-link" href="{{ route('guru.pesan.create') }}"> Kirim
                                    Pesan </a></li>

                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('threads.index') }}">
                        <i class="mdi mdi-forum menu-icon"></i>
                        <span class="menu-title">Forum Diskusi</span>
                    </a>
                </li>

            </ul>
        @endif

        @if (auth()->user()->isSiswa())
            <div class="user-profile">
                <div class="user-image">
                    <img src="{{ auth()->user()->foto ? asset('images/profil_siswa/' . auth()->user()->foto) : asset('images/default.png') }}"
                        alt="User Profile Picture">
                </div>
                <div class="user-name">
                    {{ auth()->user()->username }}
                </div>
                <div class="user-designation">
                  Pelajar
                </div>
            </div>
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('siswa.index') }}">
                        <i class="icon-box menu-icon"></i>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('siswa.jadwal') }}">
                        <i class="fas fa-calendar-alt menu-icon"></i>
                        <span class="menu-title">Jadwal Pelajaran</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('siswa.ujian.index') }}">
                        <i class="mdi mdi-school menu-icon"></i>
                        <span class="menu-title">Ujian </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('siswa.quiz.index') }}">
                        <i class="mdi mdi-puzzle-check menu-icon"></i>
                        <span class="menu-title">Daftar Kuis</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('siswa.materi.index') }}">
                        <i class="mdi mdi-book-open-page-variant menu-icon"></i>
                        <span class="menu-title">Materi</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('siswa.video') }}">
                        <i class="mdi mdi-laptop-account menu-icon"></i>
                        <span class="menu-title">Materi Video</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('siswa.tugas.index') }}">
                        <i class="mdi mdi-clipboard-text menu-icon"></i>
                        <span class="menu-title">Tugas</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('siswa.presensi.index') }}">
                        <i class="mdi mdi-clipboard-check menu-icon"></i>
                        <span class="menu-title">Presensi Online</span>
                    </a>
                </li>



                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false"
                        aria-controls="auth">
                        <i class="mdi mdi-email-box menu-icon"></i>
                        <span class="menu-title">Kotak Pesan</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="auth">
                        <ul class="nav flex-column sub-menu">

                            <li class="nav-item"> <a class="nav-link" href="{{ route('pesan.index') }}"> Pesan Masuk
                                </a></li>
                            <li class="nav-item"> <a class="nav-link" href="{{ route('pesan.pengirim') }}"> Pesan
                                    Dikirim </a></li>
                            <li class="nav-item"> <a class="nav-link" href="{{ route('pesan.create') }}"> Kirim
                                    Pesan </a></li>

                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('threads.index') }}">
                        <i class="mdi mdi-forum menu-icon"></i>
                        <span class="menu-title">Forum Diskusi</span>
                    </a>
                </li>


            </ul>
        @endif

    </nav>
    <div class="main-panel">
        <div class="content-wrapper">
