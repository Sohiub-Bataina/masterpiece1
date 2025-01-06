<!DOCTYPE html>
<html lang="en" id="theme" class="light">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="robots" content="noindex,nofollow" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('assets') }}/img/logos/Screenshot 2024-11-24 152203.png"/>
    <title>@yield('title', 'Mazadna')</title>

    <!-- Bootstrap CSS v5.2.1 -->
    <link rel="stylesheet" href="{{ asset('user-side/assets/css/all.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('user-side/assets/css/swiper.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('user-side/assets/css/bootstrap.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('user-side/assets/css/style.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('user-side/assets/css/responsive.css') }}" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

    <!-- Font Awesome CSS v6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Cairo Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- ملف CSS الخاص بـ SweetAlert2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- ملف JS الخاص بـ SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

</head>
<body>

    @include('user-side.components.navbar') <!-- تضمين الـ Navbar هنا -->

    @yield('content') <!-- المكان الذي ستُعرض فيه محتويات الصفحات الأخرى -->

    @include('user-side.components.footer') <!-- تضمين الـ Footer هنا -->

    <!-- Preloader Start -->
    <div class="preloader bg-light" id="preloader">
        <span class="preloader-inner"></span>
    </div>
    <!-- Preloader End -->

    <!-- Back-to-top Start -->
    <a href="javascript:void(0)" class="back-to-top"><i class="fa fa-up-long"></i></a>
    <!-- Back-to-top End -->

    <!-- Bootstrap JS v5.3.0-alpha1 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
