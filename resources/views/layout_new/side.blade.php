<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">

        @if(auth()->user()->isAdmin())
        <li class="nav-item">
            <a class="nav-link" href="{{route('admin.dashboard')}}">
                <i class="fas fa-tachometer-alt menu-icon"></i>
            <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('admin.jadwal.index')}}">
                <i class="fas fa-calendar-alt menu-icon"></i>
            <span class="menu-title">Jadwal Pelajaran</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{route('admin.presensi.index')}}">
                <i class="fas fa-clipboard-check menu-icon"></i>
            <span class="menu-title">Presensi Online</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('auth.change-password2') }}">
                <i class="fa-solid fa-key menu-icon"></i>
            <span class="menu-title">Ganti Password</span>
            </a>
        </li>


        <li class="nav-item">
            <a class="nav-link" href="{{route('admin.guru-mapel.index')}}">
                <i class="fas fa-users-cog menu-icon"></i>
            <span class="menu-title">Guru Mata Pelajaran</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.siswa.index') }}">
                <i class="fas fa-users menu-icon"></i>
            <span class="menu-title">Daftar Siswa</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.guru.index') }}">
                <i class="fas fa-chalkboard-teacher menu-icon"></i>
            <span class="menu-title"> Daftar Guru</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{route('admin.mapel.index')}}">
            <i class="mdi mdi-book-open-variant menu-icon"></i>
            <span class="menu-title">Master Mapel</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{route('admin.kelas.index')}}">
            <i class="mdi mdi-book-open-variant menu-icon"></i>
            <span class="menu-title">Master Kelas</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.laporan.index') }}">
                <i class="fas fa-chart-bar menu-icon"></i>
                <span class="menu-title">Laporan Siswa</span>
            </a>
        </li>
        <li class="nav-item">
            @auth
                @if(Auth::user()->role === 'admin')
                    <a class="nav-link" href="{{ route('admin.profil_admin', ['id' => Auth::id()]) }}">
                        <i class="icon-head menu-icon"></i>
                        <span class="menu-title">Profil</span>
                    </a>
                @endif
            @endauth
        </li>


        @endif


    </ul>
  </nav>
  <!-- partial -->
  <div class="main-panel">
    <div class="content-wrapper">
