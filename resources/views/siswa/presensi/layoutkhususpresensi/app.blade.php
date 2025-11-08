@include('siswa.presensi.layoutkhususpresensi.header') <!-- Include Header -->


        @include('siswa.presensi.layoutkhususpresensi.side') <!-- Include Sidebar -->


            @yield('konten') <!-- Yield untuk Konten Utama -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });
    });
</script>
