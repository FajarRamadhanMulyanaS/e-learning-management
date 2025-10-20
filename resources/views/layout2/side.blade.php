<div class="container-fluid page-body-wrapper">

    <!-- partial:partials/_sidebar.html -->
    <nav class="sidebar sidebar-offcanvas" id="sidebar">



        @if(auth()->user()->isGuru())
        <div class="user-profile">
        <div class="user-image">
            <img src="{{ auth()->user()->foto ? asset('images/profil_guru/' . auth()->user()->foto) : asset('images/default.png') }}" alt="User Profile Picture">
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
          <a class="nav-link" href="{{route('guru.index')}}">
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
          <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
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
            <a class="nav-link" data-toggle="collapse" href="#pesan" aria-expanded="false" aria-controls="pesan">
              <i class="mdi mdi-email-outline menu-icon"></i>
              <span class="menu-title">Kotak Pesan</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="pesan">
              <ul class="nav flex-column sub-menu">

                <li class="nav-item"> <a class="nav-link" href="{{ route('guru.pesan.index') }}"> Pesan Masuk </a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('guru.pesan.pengirim') }}"> Pesan Dikirim </a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('guru.pesan.create') }}"> Kirim Pesan </a></li>

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

      @if(auth()->user()->isSiswa())
      <div class="user-profile">
      <div class="user-image">
        <img src="{{ auth()->user()->foto ? asset('images/profil_siswa/' . auth()->user()->foto) : asset('images/default.png') }}" alt="User Profile Picture">
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
        <a class="nav-link" href="{{route('siswa.index')}}">
          <i class="icon-box menu-icon"></i>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{route('siswa.jadwal')}}">
          <i class="fas fa-calendar-alt menu-icon"></i>
          <span class="menu-title">Jadwal Pelajaran</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('auth.change-password') }}">
          <i class="mdi mdi-key-variant menu-icon"></i>
          <span class="menu-title">Ganti Password</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('siswa.ujian.index') }}">
          <i class="mdi mdi-school menu-icon"></i>
          <span class="menu-title">Ujian </span>
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
        <a class="nav-link" data-toggle="collapse" href="#pesan" aria-expanded="false" aria-controls="pesan">
          <i class="icon-head menu-icon"></i>
          <span class="menu-title">User Pages</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="pesan">
          <ul class="nav flex-column sub-menu">
            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                style="display: none;">
                @csrf
            </form>
            <li class="nav-item"> <a class="nav-link" href="{{ route('siswa.profil_siswa') }}"> Profil </a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ route('auth.change-password') }}"> Ganti Password </a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ route('auth.change-password') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="dropdown-item d-flex align-items-center"> Log Out </a></li>
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
          <i class="mdi mdi-email-box menu-icon"></i>
          <span class="menu-title">Kotak Pesan</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="auth">
          <ul class="nav flex-column sub-menu">

            <li class="nav-item"> <a class="nav-link" href="{{ route('pesan.index') }}"> Pesan Masuk </a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ route('pesan.pengirim') }}"> Pesan Dikirim </a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ route('pesan.create') }}"> Kirim Pesan </a></li>

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
<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
