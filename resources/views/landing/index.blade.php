<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>{{ \App\Models\LandingContent::getValue('hero_title', 'LKP. WIYATAMANDALA BENGKALIS') }}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta
        content="{{ \App\Models\LandingContent::getValue('meta_keywords', 'LKP Wiyatamandala Bengkalis, kursus komputer, pelatihan komputer, lembaga pendidikan Riau') }}"
        name="keywords">
    <meta
        content="{{ \App\Models\LandingContent::getValue('meta_description', 'LKP. WIYATAMANDALA BENGKALIS adalah lembaga kursus dan pelatihan komputer profesional yang berdiri sejak tahun 1994 di Bengkalis, Riau.') }}"
        name="description">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Roboto:wght@400;500;700;900&display=swap"
        rel="stylesheet">

    <!-- Icon Fonts -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries -->
    <link rel="stylesheet" href="{{ asset('landing/lib/animate/animate.min.css') }}" />
    <link href="{{ asset('landing/lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('landing/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Logo -->
    <link rel="shortcut icon"
        href="{{ \App\Models\LandingContent::getValue('favicon_path', asset('images/logoku.webp')) }}" />

    <!-- Bootstrap & Main Style -->
    <link href="{{ asset('landing/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('landing/css/style.css') }}" rel="stylesheet">

<style>
    /* === LOGO & NAVBAR === */
    .logo-icon {
        height: 50px;
        width: auto;
        vertical-align: middle;
    }

    .navbar {
        transition: background-color 0.4s ease, box-shadow 0.4s ease, padding 0.4s ease, color 0.4s ease;
        padding: 1rem 2rem;
        background: transparent;
    }

    .navbar.scrolled {
        background: rgba(255, 255, 255, 0.95);
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        padding: 0.6rem 1rem;
    }

    /* Warna teks default (saat belum scroll) */
    .navbar .nav-link {
        color: #ffffff !important;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    /* Warna teks saat di-scroll */
    .navbar.scrolled .nav-link {
        color: #000000 !important;
    }

    /* Hover saat di-scroll */
    .navbar.scrolled .nav-link:hover {
        color: #00d084 !important;
    }

    /* Tombol login */
    .navbar .btn-primary {
        background-color: #00d084;
        border: none;
        transition: all 0.3s ease;
    }

    .navbar .btn-primary:hover {
        background-color: #00b874;
    }

    /* Saat di-scroll, ubah warna teks tombol menjadi lebih gelap */
    .navbar.scrolled .btn-primary {
        background-color: #00d084;
        color: #fff;
    }

    /* Tombol toggler (menu hamburger) */
    .navbar-light .navbar-toggler {
        border-color: rgba(255, 255, 255, 0.5);
    }

    .navbar-light .navbar-toggler-icon {
        filter: invert(1);
        transition: filter 0.3s ease;
    }

    .navbar.scrolled .navbar-toggler-icon {
        filter: invert(0);
    }

    /* === FOTO KEGIATAN & ABOUT US === */
    .kegiatan-foto {
        width: 100%;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease;
    }

    .kegiatan-foto:hover {
        transform: scale(1.03);
    }

    .text-justify {
        text-align: justify;
    }

    /* === VISI & MISI === */
    .visi-misi-card {
        background: #f9f9f9;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
    }

    .visi-misi-card:hover {
        transform: translateY(-5px);
    }

    .visi-misi-card h4 {
        color: #00d084;
        margin-bottom: 15px;
    }

    .visi-misi-card i {
        font-size: 1.8rem;
        color: #00d084;
        margin-bottom: 10px;
    }

    .visi-misi-card {
        padding: 2.2rem 1.8rem;
        box-shadow: var(--shadow-sm);
        border: none;
        transition: var(--transition);
    }

    .visi-misi-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-md);
    }

    .visi-misi-card i {
        font-size: 2.2rem;
        margin-bottom: .9rem;
        color: #00d084;
    }
</style>


</head>

<body>
    <!-- Spinner -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center z-index-2000">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Navbar -->
    <div class="container-fluid position-relative p-0">
        <nav class="navbar navbar-expand-lg navbar-light fixed-top px-4 px-lg-5 py-3 py-lg-0">
            <a href="#" class="navbar-brand p-0">
                <h1 class="text-primary">
                    <img src="{{ \App\Models\LandingContent::getValue('logo_path', asset('landing/img/logolkp.png')) }}"
                        alt="Logo LKP Wiyatamandala" class="logo-icon me-2">
                    {{ \App\Models\LandingContent::getValue('hero_title', 'LKP. WIYATAMANDALA BENGKALIS') }}
                </h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto py-0">
                    <a href="#home" class="nav-item nav-link active">Home</a>
                    <a href="#aboutUs" class="nav-item nav-link">About Us</a>
                    <a href="#visi-misi" class="nav-item nav-link">Visi-Misi</a>
                    <a href="#contact" class="nav-item nav-link">Contact Us</a>
                </div>
                <a href="{{ route('login') }}" class="btn btn-primary rounded-pill py-2 px-4 my-3 my-lg-0">Login</a>
            </div>
        </nav>

        <!-- Hero Carousel -->
        <div id="home" class="header-carousel owl-carousel">
            <div class="header-carousel-item">
                <img src="{{ \App\Models\LandingContent::getValue('hero_bg1', asset('landing/img/bglanding.jpg')) }}"
                    class="img-fluid w-100" alt="Pelatihan komputer">
                <div class="carousel-caption">
                    <div class="container text-center">
                        <h4 class="text-primary text-uppercase fw-bold mb-4">
                            {{ \App\Models\LandingContent::getValue('hero_subtitle', 'Selamat Datang di') }}</h4>
                        <h1 class="display-4 text-uppercase text-white mb-4">
                            {{ \App\Models\LandingContent::getValue('hero_title', 'LKP. WIYATAMANDALA BENGKALIS') }}
                        </h1>
                        <p class="mb-5 fs-5">
                            {{ \App\Models\LandingContent::getValue('hero_desc', 'Lembaga Kursus dan Pelatihan Komputer sejak tahun 1994. Siap mencetak generasi terampil dan siap kerja di era digital.') }}
                        </p>
                        <a href="#aboutUs" class="btn btn-primary rounded-pill py-2 px-4">Pelajari Lebih Lanjut</a>
                    </div>
                </div>
            </div>
            <div class="header-carousel-item">
                <img src="{{ \App\Models\LandingContent::getValue('hero_bg2', asset('landing/img/carousel-2.jpg')) }}"
                    class="img-fluid w-100" alt="Kursus komputer Bengkalis">
                <div class="carousel-caption">
                    <div class="container text-center">
                        <h4 class="text-primary text-uppercase fw-bold mb-4">
                            {{ \App\Models\LandingContent::getValue('hero2_subtitle', 'Tingkatkan Skillmu') }}</h4>
                        <h1 class="display-4 text-uppercase text-white mb-4">
                            Bersama {{ \App\Models\LandingContent::getValue('hero_title', 'LKP. WIYATAMANDALA BENGKALIS') }}
                        </h1>
                        <p class="mb-5 fs-5">
                            {{ \App\Models\LandingContent::getValue('hero2_desc', 'Program pelatihan komputer 1 tahun & kelas private untuk semua usia. Belajar mudah, praktis, dan berbasis kebutuhan dunia kerja.') }}
                        </p>
                        <a href="#contact" class="btn btn-light rounded-pill py-2 px-4">Hubungi Kami</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tentang Kami -->
    <div id="aboutUs" class="container-fluid about py-5 bg-light">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 order-2 order-lg-1">
                    <h4 class="text-primary">Tentang Kami</h4>
                    <h1 class="display-5 mb-4">
                        {{ \App\Models\LandingContent::getValue('hero_title', 'LKP. WIYATAMANDALA BENGKALIS') }}</h1>
                    <p class="mb-4 text-justify">
                        {{ \App\Models\LandingContent::getValue('about_text', 'Berdiri sejak tahun 1994, kami adalah lembaga pelatihan komputer profesional di Bengkalis, Riau.') }}
                    </p>
                </div>
                <div class="col-lg-6 order-1 order-lg-2 text-center">
                    <img src="{{ \App\Models\LandingContent::getValue('about_image', asset('landing/img/lkp.jpg')) }}"
                        alt="Tentang Kami" class="img-fluid kegiatan-foto">
                </div>
            </div>
        </div>
    </div>

    <!-- Visi dan Misi -->
    <div id="visi-misi" class="container-fluid py-5 bg-white">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h4 class="text-primary">Visi dan Misi</h4>
                <h1 class="display-5">
                    {{ \App\Models\LandingContent::getValue('hero_title', 'LKP. WIYATAMANDALA BENGKALIS') }}</h1>
            </div>
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="visi-misi-card text-center">
                        <i class="bi bi-eye-fill"></i>
                        <h4>Visi</h4>
                        <p class="text-justify">
                            {{ \App\Models\LandingContent::getValue('visi', 'Menjadi lembaga kursus dan pelatihan yang unggul, profesional, dan terpercaya.') }}
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="visi-misi-card text-center">
                        <i class="bi bi-flag-fill"></i>
                        <h4>Misi</h4>
                        <p class="text-justify">
                            {{ \App\Models\LandingContent::getValue('misi', 'Memberikan pelatihan komputer berkualitas dan membangun karakter profesional peserta.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Footer -->
    <div class="container-fluid footer py-5">
        <div id="contact" class="container py-5">
            <div class="row g-5">
                <div class="col-md-6 col-lg-4">
                    <div class="footer-item">
                        <h4 class="text-white mb-4">Contact Info</h4>
                        <p class="text-white mb-2"><i
                                class="fas fa-map-marker-alt text-primary me-3"></i>{{ \App\Models\LandingContent::getValue('alamat', 'Jalan Pahlawan No.25, Bengkalis') }}
                        </p>
                        <p class="text-white mb-2"><i
                                class="fas fa-envelope text-primary me-3"></i>{{ \App\Models\LandingContent::getValue('email', 'info@lkpwiyatamandala.com') }}
                        </p>
                        <p class="text-white mb-2"><i
                                class="fa fa-phone-alt text-primary me-3"></i>{{ \App\Models\LandingContent::getValue('telepon', '0831 3310 3803') }}
                        </p>
                        <p class="text-white mb-4"><i
                                class="fab fa-firefox-browser text-primary me-3"></i>{{ \App\Models\LandingContent::getValue('website', 'www.lkpwiyatamandala.com') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid copyright py-4">
        <div class="container text-center">
            <span class="text-body text-white">&copy; {{ date('Y') }}
                {{ \App\Models\LandingContent::getValue('hero_title', 'LKP. WIYATAMANDALA BENGKALIS') }} | All Rights
                Reserved.</span>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('landing/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('landing/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('landing/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('landing/lib/counterup/counterup.min.js') }}"></script>
    <script src="{{ asset('landing/lib/lightbox/js/lightbox.min.js') }}"></script>
    <script src="{{ asset('landing/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('landing/js/main.js') }}"></script>

    <script>
        // hide spinner when page fully loaded
        $(window).on('load', function () {
            $('#spinner').fadeOut(300, function () {
                $(this).attr('aria-hidden', 'true');
            });
        });

        // ensure owl carousel has sensible defaults if main.js doesn't set it
        $(document).ready(function () {
            if ($.fn.owlCarousel && !$('.header-carousel').data('owl-initialized')) {
                $('.header-carousel').owlCarousel({
                    items: 1,
                    loop: true,
                    autoplay: true,
                    autoplayTimeout: 6000,
                    nav: false,
                    dots: true,
                    animateOut: 'fadeOut'
                }).data('owl-initialized', true);
            }
        });
    </script>
    <script>
    $(window).on('scroll', function () {
        if ($(this).scrollTop() > 50) {
            $('.navbar').addClass('scrolled');
        } else {
            $('.navbar').removeClass('scrolled');
        }
    });
</script>
</body>

</html>
