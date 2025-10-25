<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>LKP. WIYATAMANDALA BENGKALIS</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="LKP Wiyatamandala Bengkalis, kursus komputer, pelatihan komputer, lembaga pendidikan Riau" name="keywords">
    <meta content="LKP. WIYATAMANDALA BENGKALIS adalah lembaga kursus dan pelatihan komputer profesional yang berdiri sejak tahun 1994 di Bengkalis, Riau." name="description">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

    <!-- Icon Fonts -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries -->
    <link rel="stylesheet" href="{{asset ('landing') }}/lib/animate/animate.min.css"/>
    <link href="{{asset ('landing') }}/lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="{{asset ('landing') }}/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Logo -->
    <link rel="shortcut icon" href="{{ asset('images') }}/logoku.webp" />

    <!-- Bootstrap & Main Style -->
    <link href="{{asset ('landing') }}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{asset ('landing') }}/css/style.css" rel="stylesheet">
</head>

<body>
<style>
.logo-icon {
    height: 50px;
    width: auto;
    vertical-align: middle;
}
.text-justify {
    text-align: justify;
}
    .kegiatan-foto {
        width: 100%;
        max-width: 800px; /* Batas maksimal lebar gambar */
        height: auto; /* Menjaga rasio asli foto */
        object-fit: cover; /* Menyesuaikan tanpa distorsi */
        border-radius: 15px; /* Sudut melengkung */
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); /* Efek bayangan lembut */
        transition: transform 0.3s ease;
    }

    .kegiatan-foto:hover {
        transform: scale(1.03); /* Sedikit zoom saat hover */
    }
</style>

<!-- Spinner -->
<div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>
<!-- Spinner End -->

<!-- Navbar -->
<div class="container-fluid position-relative p-0">
    <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
        <a href="#" class="navbar-brand p-0">
            <h1 class="text-primary">
                <img src="{{ asset('landing/img/logolkp.png') }}" alt="Logo LKP Wiyatamandala" class="logo-icon">
                LKP. WIYATAMANDALA BENGKALIS
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
            <img src="{{ asset('landing/img/bglanding.jpg') }}" class="img-fluid w-100" alt="Pelatihan komputer">
            <div class="carousel-caption">
                <div class="container">
                    <div class="text-center">
                        <h4 class="text-primary text-uppercase fw-bold mb-4">Selamat Datang di</h4>
                        <h1 class="display-4 text-uppercase text-white mb-4">LKP. WIYATAMANDALA BENGKALIS</h1>
                        <p class="mb-5 fs-5">
                            Lembaga Kursus dan Pelatihan Komputer sejak tahun 1994.<br>
                            Siap mencetak generasi terampil, profesional, dan siap kerja di era digital.
                        </p>
                        <a href="#aboutUs" class="btn btn-primary rounded-pill py-2 px-4">Pelajari Lebih Lanjut</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="header-carousel-item">
            <img src="{{asset ('landing') }}/img/carousel-2.jpg" class="img-fluid w-100" alt="Kursus komputer Bengkalis">
            <div class="carousel-caption">
                <div class="container text-center">
                    <h4 class="text-primary text-uppercase fw-bold mb-4">Tingkatkan Skillmu</h4>
                    <h1 class="display-4 text-uppercase text-white mb-4">Bersama LKP. WIYATAMANDALA BENGKALIS</h1>
                    <p class="mb-5 fs-5">
                        Program pelatihan komputer 1 tahun & kelas private untuk semua usia.<br>
                        Belajar mudah, praktis, dan berbasis kebutuhan dunia kerja.
                    </p>
                    <a href="#contact" class="btn btn-light rounded-pill py-2 px-4">Hubungi Kami</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Navbar & Hero End -->

<!-- About Start -->
<div id="aboutUs" class="container-fluid about py-5 bg-light">
    <div class="container py-5">
        <div class="row g-5 align-items-center justify-content-center text-center">
            <!-- Kolom Teks -->
            <div class="col-xl-8 wow fadeInUp" data-wow-delay="0.2s">
                <h4 class="text-primary">Tentang Kami</h4>
                <h1 class="display-5 mb-4">LKP. WIYATAMANDALA BENGKALIS</h1>
                <p class="mb-4 text-justify text-center">
                    Berdiri sejak tahun <strong>1994</strong>, <strong>LKP. WIYATAMANDALA BENGKALIS</strong> merupakan 
                    lembaga kursus dan pelatihan komputer yang berkomitmen mencetak sumber daya manusia 
                    yang unggul dan siap bersaing di dunia kerja.
                </p>
                <p class="mb-4 text-justify text-center">
                    Kami menyediakan berbagai program pelatihan, mulai dari <strong>Program 1 Tahun</strong> hingga 
                    <strong>Kelas Private</strong>, yang dirancang untuk membantu peserta menguasai teknologi komputer 
                    secara profesional.
                </p>
                <p class="mb-4 text-justify text-center">
                    Dengan instruktur berpengalaman dan metode pembelajaran berbasis praktik, kami siap mendampingi peserta 
                    untuk mencapai kompetensi terbaik di bidang teknologi informasi.
                </p>
            </div>

            <!-- Kolom Gambar -->
            <div class="col-xl-8 text-center">
                <img src="{{ asset('landing/img/lkp.jpg') }}" 
                     alt="Kegiatan di LKP Wiyatamandala Bengkalis" 
                     class="img-fluid rounded shadow-lg kegiatan-foto">
            </div>
        </div>
    </div>
</div>
<!-- Visi dan Misi -->
<div id="visi-misi" class="container-fluid py-5 bg-white">
    <div class="container py-5">
        <div class="text-center mb-4">
            <h4 class="text-primary">Visi dan Misi</h4>
            <h1 class="display-5">LKP. WIYATAMANDALA BENGKALIS</h1>
        </div>
        <div class="row g-5">
            <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.2s">
                <h4 class="text-primary">Visi</h4>
                <p class="text-justify">
                    Menjadi lembaga kursus dan pelatihan yang unggul, profesional, dan terpercaya dalam mencetak sumber daya manusia 
                    yang terampil, berkompeten, serta mampu bersaing di dunia kerja berbasis teknologi informasi.
                </p>
            </div>
            <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.2s">
                <h4 class="text-primary">Misi</h4>
                <ul class="list-group list-group-flush text-justify">
                    <li class="list-group-item">Menyelenggarakan kursus komputer yang berkualitas dan sesuai kebutuhan industri.</li>
                    <li class="list-group-item">Meningkatkan keterampilan peserta dalam bidang teknologi informasi.</li>
                    <li class="list-group-item">Mengembangkan metode pembelajaran yang inovatif dan berorientasi praktik.</li>
                    <li class="list-group-item">Membangun karakter profesional, disiplin, dan mandiri bagi setiap peserta.</li>
                    <li class="list-group-item">Menjalin kemitraan dengan dunia kerja untuk membuka peluang karir bagi lulusan.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Visi dan Misi End -->

<!-- Footer -->
<div class="container-fluid footer py-5 wow fadeIn" data-wow-delay="0.2s">
    <div id="contact" class="container py-5 border-start-0 border-end-0" style="border: 1px solid rgba(255, 255, 255, 0.08);">
        <div class="row g-5">
            <!-- Contact Info -->
            <div class="col-md-6 col-lg-4">
                <div class="footer-item">
                    <h4 class="text-white mb-4">Contact Info</h4>
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-map-marker-alt text-primary me-3"></i>
                        <p class="text-white mb-0">Jalan Pahlawan No. 25, Bengkalis, Riau, Indonesia</p>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-envelope text-primary me-3"></i>
                        <p class="text-white mb-0">info@lkpwiyatamandala.com</p>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <i class="fa fa-phone-alt text-primary me-3"></i>
                        <p class="text-white mb-0">0831 3310 3803</p>
                    </div>
                    <div class="d-flex align-items-center mb-4">
                        <i class="fab fa-firefox-browser text-primary me-3"></i>
                        <p class="text-white mb-0">www.lkpwiyatamandala.com</p>
                    </div>
                    <div class="d-flex">
                        <a class="btn btn-primary btn-sm-square rounded-circle me-3" href="#"><i class="fab fa-facebook-f text-white"></i></a>
                        <a class="btn btn-primary btn-sm-square rounded-circle me-3" href="#"><i class="fab fa-instagram text-white"></i></a>
                        <a class="btn btn-primary btn-sm-square rounded-circle me-0" href="#"><i class="fab fa-linkedin-in text-white"></i></a>
                    </div>
                </div>
            </div>

            <!-- About Us -->
            <div class="col-md-6 col-lg-4">
                <div class="footer-item">
                    <h4 class="text-white mb-4">About Us</h4>
                    <p class="text-white-50">
                        <strong>LKP. WIYATAMANDALA BENGKALIS</strong> adalah lembaga kursus dan pelatihan komputer 
                        yang telah berdiri sejak tahun 1994. Kami fokus pada pengembangan keterampilan digital dan 
                        kompetensi teknologi bagi masyarakat Bengkalis dan sekitarnya.
                    </p>
                    <p class="text-white-50">
                        <strong>Program:</strong> Kursus Komputer (Program 1 Tahun & Private)
                    </p>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-md-6 col-lg-4">
                <div class="footer-item">
                    <h4 class="text-white mb-4">Quick Links</h4>
                    <ul class="list-unstyled">
                        <li><a class="text-white-50 text-decoration-none" href="#home">Home</a></li>
                        <li><a class="text-white-50 text-decoration-none" href="#aboutUs">About Us</a></li>
                        <li><a class="text-white-50 text-decoration-none" href="#visi-misi">Visi & Misi</a></li>
                        <li><a class="text-white-50 text-decoration-none" href="#contact">Contact</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->

<!-- Copyright -->
<div class="container-fluid copyright py-4">
    <div class="container text-center">
        <span class="text-body">
            <a href="#" class="border-bottom text-white">
                <i class="fas fa-copyright text-light me-2"></i>
                LKP. WIYATAMANDALA BENGKALIS
            </a> | All Rights Reserved.
        </span>
    </div>
</div>

<!-- Back to Top -->
<a href="#" class="btn btn-primary btn-lg-square rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>

<!-- Scripts -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{asset ('landing') }}/lib/wow/wow.min.js"></script>
<script src="{{asset ('landing') }}/lib/easing/easing.min.js"></script>
<script src="{{asset ('landing') }}/lib/waypoints/waypoints.min.js"></script>
<script src="{{asset ('landing') }}/lib/counterup/counterup.min.js"></script>
<script src="{{asset ('landing') }}/lib/lightbox/js/lightbox.min.js"></script>
<script src="{{asset ('landing') }}/lib/owlcarousel/owl.carousel.min.js"></script>
<script src="{{asset ('landing') }}/js/main.js"></script>
</body>
</html>
