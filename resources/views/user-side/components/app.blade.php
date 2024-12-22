<!-- resources/views/user-side/components/app.blade.php -->
<!DOCTYPE html>
<html lang="en" id="theme" class="light">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="robots" content="noindex,nofollow" />
    <link rel="shortcut icon" href="{{ asset('assets') }}/img/logos/Screenshot 2024-11-24 152203.png"/>
    <title>@yield('title', 'Mazadna')</title>

    <!-- Bootstrap CSS v5.2.1 -->
    <link rel="stylesheet" href="{{ asset('user-side/assets/css/all.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('user-side/assets/css/swiper.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('user-side/assets/css/bootstrap.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('user-side/assets/css/style.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('user-side/assets/css/responsive.css') }}" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
</head>
<body>
    @include('user-side.components.navbar') <!-- تضمين الـ Navbar هنا -->

    @yield('content') <!-- المكان الذي ستُعرض فيه محتويات الصفحات الأخرى -->
    
    <!-<!DOCTYPE html>
<html lang="en" id="theme" class="light">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="robots" content="noindex,nofollow" />
    <link rel="shortcut icon" href="{{ asset('assets/images/auction-fevicon.png') }}" />
    <title>@yield('title', 'Mazadna')</title>

    <!-- Bootstrap CSS v5.2.1 -->
    <link rel="stylesheet" href="{{ asset('user-side/assets/css/all.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('user-side/assets/css/swiper.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('user-side/assets/css/bootstrap.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('user-side/assets/css/style.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('user-side/assets/css/responsive.css') }}" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

    <!-- Preloader Start -->
    <div class="preloader bg-light" id="preloader">
        <span class="preloader-inner"></span>
    </div>
    <!-- Preloader End -->

    <!-- Back-to-top Start -->
    <a href="javascript:void(0)" class="back-to-top"><i class="fa fa-up-long"></i></a>
    <!-- Back-to-top End -->



    @include('user-side.components.footer')
  <!-- Footer شامل لجميع الصفحات -->

</body>
</html>

