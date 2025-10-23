<!DOCTYPE html>
<html lang="en">

<head>
     <!-- Plugin css for this page -->
     <link rel="stylesheet" href="{{ asset('New') }}/vendors/mdi/css/materialdesignicons.min.css">

     <!-- Link ke Font Awesome CDN -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
 
     <!-- CSS Bootstrap 5 -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
 
     <!-- Google Fonts -->
     <link href="https://fonts.gstatic.com" rel="preconnect">
     <link
         href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
         rel="stylesheet">
 
     <!-- Required meta tags -->
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
     <title>Admin</title>
     <!-- plugins:css -->
     <link rel="stylesheet" href="{{ asset('New') }}/vendors/feather/feather.css">
     <link rel="stylesheet" href="{{ asset('New') }}/vendors/ti-icons/css/themify-icons.css">
     <link rel="stylesheet" href="{{ asset('New') }}/vendors/css/vendor.bundle.base.css">
     <!-- endinject -->
     <!-- Plugin css for this page -->
     <link rel="stylesheet" href="{{ asset('New') }}/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
     <link rel="stylesheet" href="{{ asset('New') }}/vendors/ti-icons/css/themify-icons.css">
     <link rel="stylesheet" type="text/css" href="{{ asset('New') }}/js/select.dataTables.min.css">
     <!-- End plugin css for this page -->
     <!-- inject:css -->
     <link rel="stylesheet" href="{{ asset('New') }}/css/vertical-layout-light/style.css">
     <!-- endinject -->
     <link rel="shortcut icon" href="{{ asset('images') }}/logoku.webp"/>
 

    <link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">

    <!-- Link ke Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- base:css -->
    <link rel="stylesheet" href="{{ asset('Siswa') }}/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="{{ asset('Siswa') }}/vendors/feather/feather.css">
    <link rel="stylesheet" href="{{ asset('Siswa') }}/vendors/base/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('Siswa') }}/vendors/flag-icon-css/css/flag-icon.min.css" />
    <link rel="stylesheet" href="{{ asset('Siswa') }}/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('Siswa') }}/vendors/jquery-bar-rating/fontawesome-stars-o.css">
    <link rel="stylesheet" href="{{ asset('Siswa') }}/vendors/jquery-bar-rating/fontawesome-stars.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('Siswa') }}/css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('images') }}/logoku.webp"/>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/costom.css') }}">

    
</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-left justify-content-center">
                <a class="navbar-brand brand-logo" href="index.html">
                    <img src="https://disdikbud.banyuasinkab.go.id/wp-content/uploads/sites/269/2022/11/Logo-Tut-Wuri-Handayani-PNG-Warna.png"
                        alt="logo" />
                </a>
                <a class="navbar-brand brand-logo-mini" href="index.html">
                    <img src="https://disdikbud.banyuasinkab.go.id/wp-content/uploads/sites/269/2022/11/Logo-Tut-Wuri-Handayani-PNG-Warna.png" alt="logo" />
                </a>
            </div>

            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="icon-menu"></span>
                </button>
                <ul class="navbar-nav mr-lg-2">
                    <li class="nav-item nav-search d-none d-lg-block">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="search">
                                    <i class="icon-search"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" placeholder="Search Projects.."
                                aria-label="search" aria-describedby="search">
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav navbar-nav-right">

                    <li class="nav-item dropdown d-flex">
                        <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center"
                            id="messageDropdown" href="#" data-toggle="dropdown">
                            <i class="icon-air-play mx-0"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                            aria-labelledby="messageDropdown">
                            <p class="mb-0 font-weight-normal float-left dropdown-header">Messages</p>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <img src="images/faces/face4.jpg" alt="image" class="profile-pic">
                                </div>
                                <div class="preview-item-content flex-grow">
                                    <h6 class="preview-subject ellipsis font-weight-normal">David Grey
                                    </h6>
                                    <p class="font-weight-light small-text text-muted mb-0">
                                        The meeting is cancelled
                                    </p>
                                </div>
                            </a>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <img src="images/faces/face2.jpg" alt="image" class="profile-pic">
                                </div>
                                <div class="preview-item-content flex-grow">
                                    <h6 class="preview-subject ellipsis font-weight-normal">Tim Cook
                                    </h6>
                                    <p class="font-weight-light small-text text-muted mb-0">
                                        Siswa product launch
                                    </p>
                                </div>
                            </a>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <img src="images/faces/face3.jpg" alt="image" class="profile-pic">
                                </div>
                                <div class="preview-item-content flex-grow">
                                    <h6 class="preview-subject ellipsis font-weight-normal"> Johnson
                                    </h6>
                                    <p class="font-weight-light small-text text-muted mb-0">
                                        Upcoming board meeting
                                    </p>
                                </div>
                            </a>
                        </div>
                    </li>
                    <li class="nav-item dropdown d-flex mr-4">
                        <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center"
                            id="notificationDropdown" href="#" data-toggle="dropdown">
                            <i class="icon-cog"></i>
                        </a>
                    
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                            aria-labelledby="notificationDropdown">
                            <p class="mb-0 font-weight-normal float-left dropdown-header">Settings</p>
                    
                            {{-- Profil --}}
                            @if(auth()->user()->isGuru())
                            <a class="dropdown-item preview-item" href="{{ route('guru.profil.profil_guru') }}">
                                <i class="icon-head"></i> Profile
                            </a>
                            @endif
                    
                            @if(auth()->user()->isSiswa())
                            <a class="dropdown-item preview-item" href="{{ route('siswa.profil_siswa') }}">
                                <i class="icon-head"></i> Profile
                            </a>
                            @endif
                    
                         
                               {{-- Ganti Password --}}
        <a class="dropdown-item preview-item"  href="{{ route('auth.change-password') }}">
            <i class="mdi mdi-key-variant"></i> Ganti Password
        </a>

                    
                            <div class="dropdown-divider"></div>
                    
                            {{-- Logout --}}
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <a class="dropdown-item d-flex align-items-center" href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="icon-inbox"></i> Logout
                            </a>
                        </div>
                    </li>
                    
                    <li class="nav-item dropdown mr-4 d-lg-flex d-none">
                        <a class="nav-link count-indicatord-flex align-item s-center justify-content-center"
                            href="#">
                            <i class="icon-grid"></i>
                        </a>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="offcanvas">
                    <span class="icon-menu"></span>
                </button>
            </div>
        </nav>
