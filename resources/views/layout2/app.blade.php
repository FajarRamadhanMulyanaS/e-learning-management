
@include('layout2.header') <!-- Include Header -->

<div class="container-fluid">
    <div class="row">
        @include('layout2.side') <!-- Include Sidebar -->


            @yield('konten') <!-- Yield untuk Konten Utama -->

    </div>
</div>



@include('layout2.footer') <!-- Include Footer -->
