<div class="wrapper">
    <!-- ======= Header ======= -->
    @include('layout.header')

    <div class="content-area">
      <!-- ======= Sidebar ======= -->
      @include('layout.side')

      <!-- ======= Konten Utama ======= -->
      <main id="main" class="main">
        <div class="pagetitle">
          <h1>@yield('page-title')</h1>
        </div>

        <section class="section dashboard">
          @yield('konten')
        </section>
      </main>
    </div>

    <!-- ======= Footer ======= -->
    @include('layout.footer')
  </div>
