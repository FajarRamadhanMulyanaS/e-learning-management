<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>E-learning School</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

        <!-- Icon Font Stylesheet -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link rel="stylesheet" href="{{asset ('landing') }}/lib/animate/animate.min.css"/>
        <link href="{{asset ('landing') }}/lib/lightbox/css/lightbox.min.css" rel="stylesheet">
        <link href="{{asset ('landing') }}/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

        <link rel="shortcut icon" href="{{ asset('images') }}/logoku.webp" />
        <!-- Customized Bootstrap Stylesheet -->
        <link href="{{asset ('landing') }}/css/bootstrap.min.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="{{asset ('landing') }}/css/style.css" rel="stylesheet">
    </head>

    <body>
<style>
    .logo-icon {
    height: 50px; /* Sesuaikan ukuran */
    width: auto;
    display: inline-block;
    vertical-align: middle;
    }
    .text-justify {
        text-align: justify;
    }


</style>
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Navbar & Hero Start -->
        <div class="container-fluid position-relative p-0">
            <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
                <a href="" class="navbar-brand p-0">
                    <h1 class="text-primary">
                        <img src="{{ asset('images/logoku.webp') }}" alt="E-learning Logo" class="logo-icon">
                        E-learning School
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
                    <a href="{{ route('login')}}" class="btn btn-primary rounded-pill py-2 px-4 my-3 my-lg-0 flex-shrink-0">Login</a>
                </div>
            </nav>


            <!-- Carousel Start -->
            <div id="home" class="header-carousel owl-carousel">
                <div class="header-carousel-item">
                    <img src="{{asset ('landing') }}/img/carousel-1.jpg" class="img-fluid w-100" alt="Image">
                    <div class="carousel-caption">
                        <div class="container">
                            <div class="row gy-0 gx-5">
                                <div class="col-lg-0 col-xl-5"></div>
                                <div class="col-xl-7 animated fadeInLeft">
                                    <div class="text-sm-center text-md-end">
                                        <h4 class="text-primary text-uppercase fw-bold mb-4">Welcome To Stocker</h4>
                                        <h1 class="display-4 text-uppercase text-white mb-4">RAIH PRESTASI BERSAMA SMP 2 JEKULO</h1>
                                        <p class="mb-5 fs-5">SMP 2 Jekulo berkomitmen menciptakan generasi cerdas, berkarakter, dan berprestasi dengan dukungan pembelajaran modern dan berbasis teknologi
                                        </p>

                                        <div class="d-flex align-items-center justify-content-center justify-content-md-end">
                                            <h2 class="text-white me-2">Follow Us:</h2>
                                            <div class="d-flex justify-content-end ms-2">
                                                <a class="btn btn-md-square btn-light rounded-circle me-2" href=""><i class="fab fa-facebook-f"></i></a>
                                                <a class="btn btn-md-square btn-light rounded-circle mx-2" href=""><i class="fab fa-twitter"></i></a>
                                                <a class="btn btn-md-square btn-light rounded-circle mx-2" href=""><i class="fab fa-instagram"></i></a>
                                                <a class="btn btn-md-square btn-light rounded-circle ms-2" href=""><i class="fab fa-linkedin-in"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="header-carousel-item">
                    <img src="{{asset ('landing') }}/img/carousel-2.jpg" class="img-fluid w-100" alt="Image">
                    <div class="carousel-caption">
                        <div class="container">
                            <div class="row g-5">
                                <div class="col-12 animated fadeInUp">
                                    <div class="text-center">
                                        <h4 class="text-primary text-uppercase fw-bold mb-4">Welcome To Stocker</h4>
                                        <h1 class="display-4 text-uppercase text-white mb-4">RAIH PRESTASI BERSAMA SMP 2 JEKULO</h1>
                                        <p class="mb-5 fs-5">SMP 2 Jekulo berkomitmen menciptakan generasi cerdas, berkarakter, dan berprestasi dengan dukungan pembelajaran modern dan berbasis teknologi...
                                        </p>

                                        <div class="d-flex align-items-center justify-content-center">
                                            <h2 class="text-white me-2">Follow Us:</h2>
                                            <div class="d-flex justify-content-end ms-2">
                                                <a class="btn btn-md-square btn-light rounded-circle me-2" href=""><i class="fab fa-facebook-f"></i></a>
                                                <a class="btn btn-md-square btn-light rounded-circle mx-2" href=""><i class="fab fa-twitter"></i></a>
                                                <a class="btn btn-md-square btn-light rounded-circle mx-2" href=""><i class="fab fa-instagram"></i></a>
                                                <a class="btn btn-md-square btn-light rounded-circle ms-2" href=""><i class="fab fa-linkedin-in"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Carousel End -->
        </div>
        <!-- Navbar & Hero End -->


        <!-- About Start -->
<div id="aboutUs" class="header-carousel owl-carousel">
    <div class="container-fluid about py-5">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <!-- Kolom Sambutan Kepala Sekolah -->
                <div class="col-xl-7 wow fadeInLeft" data-wow-delay="0.2s">
                    <div>
                        <h4  class="text-primary">About Us</h4>
                        <h1 class="display-5 mb-4">Sambutan Kepala Sekolah</h1>
                        <p class="mb-4">
                            Assalamualaikum Warohmatullahi Wabarokatuh,<br>
                            Kami ucapkan syukur alhamdulillah ke hadirat Allah SWT yang telah melimpahkan rahmat dan karunia-Nya sehingga SMP 2 Jekulo Kudus telah berhasil menyempurnakan website sekolah dengan nama <strong>smp2jekulokudus.sch.id</strong>.
                        </p>
                        <p class="mb-4">
                            Kemajuan teknologi informasi dan komunikasi saat ini menuntut kita untuk siap menghadapi dan memanfaatkannya. Berbagai sarana digital yang dapat digunakan untuk mengakses informasi maju pesat. Internet menjadi kebutuhan yang vital bagi seluruh aktivitas manusia.
                        </p>
                        <p class="mb-4">
                            Seiring dengan kemajuan tersebut, dunia pendidikan juga mengalami perkembangan yang pesat. Berbagai aktivitas di sekolah menjadi lebih mudah diakses dan dipublikasikan. Semua warga sekolah bisa berperan secara aktif untuk menyampaikan berbagai informasi yang terkait pendidikan. Aneka sumber belajar secara daring dapat memperkaya dan meningkatkan kompetensi warga sekolah.
                        </p>
                        <p class="mb-4">
                            Wassalamualaikum Warahmatullahi Wabarokatuh.
                        </p>
                    </div>
                </div>
                <!-- Kolom Foto Kepala Sekolah -->
                <div class="col-xl-5 wow fadeInRight" data-wow-delay="0.2s">
                    <div class="bg-primary rounded position-relative overflow-hidden">
                        <img src="https://www.smp2jekulokudus.sch.id/images/2023/05/23/pak-jupri-1.jpg"
                            class="img-fluid rounded w-100" alt="Foto Kepala Sekolah">
                        <p class="text-center text-white mt-3">JUPRI, S.Pd</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- About End -->

<!-- Visi dan Misi Start -->
<div id="visi-misi" class="container-fluid py-5 bg-light">
    <div class="container-fluid py-5 bg-light">
        <div class="container py-5">
            <div class="row">
                <div class="col-12 text-center mb-4">
                    <h4 class="text-primary">Visi dan Misi</h4>
                    <h1 class="display-5">SMP 2 Jekulo</h1>
                </div>
            </div>
            <div class="row g-5">
                <!-- Visi -->
                <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.2s">
                    <h4 class="text-primary">Visi</h4>
                    <p class="text-justify">
                        Terwujudnya peningkatan prestasi akademik peserta didik;<br>
                        Terwujudnya peningkatan prestasi nonakademik peserta didik;<br>
                        Terwujudnya peserta didik yang terampil dalam menguasai Ilmu Pengetahuan dan Teknologi;<br>
                        Terwujudnya pendidikan yang mengedepankan pembentukan profil pelajar Pancasila, yang memiliki enam dimensi utama yaitu:
                        <ol>
                            <li>Beriman, bertakwa kepada Tuhan Yang Maha Esa, dan berakhlak mulia</li>
                            <li>Mandiri</li>
                            <li>Bernalar Kritis</li>
                            <li>Kreatif</li>
                            <li>Bergotong-royong</li>
                            <li>Berkebinekaan global</li>
                        </ol>
                        Terwujudnya perlindungan dan pengelolaan lingkungan hidup melalui upaya pelestarian fungsi lingkungan, pencegahan pencemaran dan kerusakan lingkungan;<br>
                        Terwujudnya sekolah adiwiyata tingkat nasional yang memiliki budaya dan lingkungan sekolah yang bersih, rindang, asri, aman, dan nyaman.
                    </p>
                </div>
                <!-- Misi -->
                <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.2s">
                    <h4 class="text-primary">Misi</h4>
                    <ul class="list-group list-group-flush text-justify">
                        <li class="list-group-item">Mewujudkan pembelajaran yang aktif, kreatif, efektif, dan menyenangkan untuk meraih prestasi akademik.</li>
                        <li class="list-group-item">Menggali seluruh potensi peserta didik dan mengembangkan minat dan bakatnya secara optimal untuk meraih prestasi nonakademik.</li>
                        <li class="list-group-item">Mewujudkan peserta didik yang terampil dalam menguasai Ilmu Pengetahuan dan Teknologi.</li>
                        <li class="list-group-item">
                            Mewujudkan peningkatan karakter profil pelajar yang meliputi 6 dimensi, yaitu:
                            <ul>
                                <li>Beriman, bertakwa kepada Tuhan Yang Maha Esa, dan berakhlak mulia</li>
                                <li>Mandiri</li>
                                <li>Bernalar Kritis</li>
                                <li>Kreatif</li>
                                <li>Bergotong-royong</li>
                                <li>Berkebinekaan global</li>
                            </ul>
                        </li>
                        <li class="list-group-item">Mewujudkan perlindungan dan pengelolaan lingkungan hidup melalui upaya pelestarian fungsi lingkungan, pencegahan pencemaran, dan kerusakan alam.</li>
                        <li class="list-group-item">Mewujudkan sekolah adiwiyata nasional yang memiliki budaya bersih dan sehat sehingga terbentuk lingkungan sekolah yang bersih, rindang, asri, aman, dan nyaman.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Visi dan Misi End -->


        <!-- Footer Start -->
<div class="container-fluid footer py-5 wow fadeIn" data-wow-delay="0.2s">
    <div id="contact" class="container-fluid contact py-5">
        <div class="container py-5 border-start-0 border-end-0" style="border: 1px solid; border-color: rgba(255, 255, 255, 0.08);">
            <div class="row g-5">
                <!-- Contact Info -->
                <div class="col-md-6 col-lg-4">
                    <div class="footer-item">
                        <h4 class="text-white mb-4">Contact Info</h4>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-map-marker-alt text-primary me-3"></i>
                            <p class="text-white mb-0">Jl. Tanjungrejo No.1/I, Patian, Tanjungrejo, Kec. Jekulo, Kabupaten Kudus, Jawa Tengah 59382</p>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-envelope text-primary me-3"></i>
                            <p class="text-white mb-0">smp2jekulokds@gmail.com</p>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fa fa-phone-alt text-primary me-3"></i>
                            <p class="text-white mb-0">02914253350</p>
                        </div>
                        <div class="d-flex align-items-center mb-4">
                            <i class="fab fa-firefox-browser text-primary me-3"></i>
                            <p class="text-white mb-0">Yoursite@ex.com</p>
                        </div>
                        <div class="d-flex">
                            <a class="btn btn-primary btn-sm-square rounded-circle me-3" href="#"><i class="fab fa-facebook-f text-white"></i></a>
                            <a class="btn btn-primary btn-sm-square rounded-circle me-3" href="#"><i class="fab fa-twitter text-white"></i></a>
                            <a class="btn btn-primary btn-sm-square rounded-circle me-3" href="#"><i class="fab fa-instagram text-white"></i></a>
                            <a class="btn btn-primary btn-sm-square rounded-circle me-0" href="#"><i class="fab fa-linkedin-in text-white"></i></a>
                        </div>
                    </div>
                </div>

                <!-- About Us -->
                <div class="col-md-6 col-lg-4" >
                    <div class="footer-item">
                        <h4 class="text-white mb-4">About Us</h4>
                        <p class="text-white-50">
                            SMP 2 Jekulo berkomitmen untuk memberikan pendidikan berkualitas dengan suasana yang mendukung perkembangan siswa secara holistik.
                        </p>
                        <p class="text-white-50">
                            Kami fokus pada pembelajaran yang inovatif, kolaboratif, dan berbasis nilai moral untuk membentuk generasi penerus yang unggul.
                        </p>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-md-6 col-lg-4">
                    <div class="footer-item">
                        <h4 class="text-white mb-4">Quick Links</h4>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a class="text-white-50 text-decoration-none" href="#home">Home</a></li>
                            <li class="mb-2"><a class="text-white-50 text-decoration-none" href="#aboutUs">About Us</a></li>
                            <li class="mb-2"><a class="text-white-50 text-decoration-none" href="#visi-misi">Visi - Misi</a></li>
                            <li class="mb-2"><a class="text-white-50 text-decoration-none" href="#contact">Contact</a></li>
                            <li class="mb-2"><a class="text-white-50 text-decoration-none" href="#">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
<!-- Footer End -->


        <!-- Copyright Start -->
        <div class="container-fluid copyright py-4">
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-md-6 text-center text-md-start mb-md-0">
                        <span class="text-body"><a href="#" class="border-bottom text-white"><i class="fas fa-copyright text-light me-2"></i>E-learning School</a>, All right reserved.</span>
                    </div>
                    <div class="col-md-6 text-center text-md-end text-body">
                        <!--/*** This template is free as long as you keep the below author’s credit link/attribution link/backlink. ***/-->
                        <!--/*** If you'd like to use the template without the below author’s credit link/attribution link/backlink, ***/-->
                        <!--/*** you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". ***/-->
                        Designed By <a class="border-bottom text-white" href="https://htmlcodex.com">Anugrah</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Copyright End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-primary btn-lg-square rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>


        <!-- JavaScript Libraries -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{asset ('landing') }}/lib/wow/wow.min.js"></script>
        <script src="{{asset ('landing') }}/lib/easing/easing.min.js"></script>
        <script src="{{asset ('landing') }}/lib/waypoints/waypoints.min.js"></script>
        <script src="{{asset ('landing') }}/lib/counterup/counterup.min.js"></script>
        <script src="{{asset ('landing') }}/lib/lightbox/js/lightbox.min.js"></script>
        <script src="{{asset ('landing') }}/lib/owlcarousel/owl.carousel.min.js"></script>

        <script>
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();

                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        window.scrollTo({
                            top: target.offsetTop,
                            behavior: 'smooth'
                        });
                    }
                });
            });
        </script>


        <!-- Template Javascript -->
        <script src="{{asset ('landing') }}/js/main.js"></script>
    </body>

</html>
