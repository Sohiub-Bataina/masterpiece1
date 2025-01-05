<!DOCTYPE html>
<html lang="en" id="theme" class="light">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('assets/images/auction-fevicon.png') }}">
    <title>Page Not Found</title>
    <!-- Bootstrap CSS v5.2.1 -->
    <link rel="stylesheet" href="{{ asset('user-side/assets/css/all.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('user-side/assets/css/bootstrap.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('user-side/assets/css/style.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('user-side/assets/css/responsive.css') }}" type="text/css" />
</head>

<body>
    <!-- Preloader Start -->
    <div class="preloader bg-light" id="preloader">
        <span class="preloader-inner"></span>
    </div>
    <!-- Preloader End -->


    <div class="vh-100 d-flex justify-content-center align-items-center text-center">
        <div class="error-wrapper-content">
            <img src="{{ asset('user-side/assets/images/404.svg') }}" alt="error-img">
            <h3>Page not found</h3>
            <span class="d-block mb-4">Let's redirect you to our homepage and start the bidding adventure anew.</span>
            <a href="{{ url('home') }}" class="primary-btn light-btn d-inline-block border-dark mt-5">Back to HOME</a>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="{{ asset('user-side/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('user-side/assets/js/custom.js') }}"></script>

    <script>
        (function() {
            function c() {
                var b = a.contentDocument || a.contentWindow.document;
                if (b) {
                    var d = b.createElement('script');
                    d.innerHTML = "window.__CF$cv$params={r:'8e047fd039678ab3',t:'MTczMTIyNTUyNS4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='../cdn-cgi/challenge-platform/h/b/scripts/jsd/22755d9a86c9/maind41d.js';document.getElementsByTagName('head')[0].appendChild(a);";
                    b.getElementsByTagName('head')[0].appendChild(d);
                }
            }

            if (document.body) {
                var a = document.createElement('iframe');
                a.height = 1;
                a.width = 1;
                a.style.position = 'absolute';
                a.style.top = 0;
                a.style.left = 0;
                a.style.border = 'none';
                a.style.visibility = 'hidden';
                document.body.appendChild(a);
                if ('loading' !== document.readyState) c();
                else if (window.addEventListener)
                    document.addEventListener('DOMContentLoaded', c);
                else {
                    var e = document.onreadystatechange || function() {};
                    document.onreadystatechange = function(b) {
                        e(b);
                        'loading' !== document.readyState &&
                            ((document.onreadystatechange = e), c());
                    };
                }
            }
        })();
    </script>
</body>

</html>
