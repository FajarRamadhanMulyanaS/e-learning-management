@include('layout_siswa.header') <!-- Include Header -->

<div class="container-fluid">
    <div class="row">
        @include('layout_siswa.side') <!-- Include Sidebar -->


            @yield('konten') <!-- Yield untuk Konten Utama -->

    </div>
</div>



@include('layout_siswa.footer') <!-- Include Footer -->