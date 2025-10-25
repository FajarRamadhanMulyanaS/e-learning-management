@include('siswa.presensi.layoutkhususpresensi.header') <!-- Include Header -->

<div class="container-fluid">
    <div class="row">
        @include('siswa.presensi.layoutkhususpresensi.side') <!-- Include Sidebar -->


            @yield('konten') <!-- Yield untuk Konten Utama -->

    </div>
</div>


