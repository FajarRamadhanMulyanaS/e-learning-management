
@include('layout_new.header') <!-- Include Header -->

<div class="container-fluid">
    <div class="row">
        @include('layout_new.side') <!-- Include Sidebar -->


            @yield('konten') <!-- Yield untuk Konten Utama -->

    </div>
</div>



@include('layout_new.footer') <!-- Include Footer -->