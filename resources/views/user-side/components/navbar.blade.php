<header class="bg-white">
    <nav class="navbar navbar-expand-lg py-3">
        <div class="container">
            <a class="navbar-brand p-0" href="{{ route('user-side.home') }}">
                <img src="{{ asset('assets') }}/img/logos/image-removebg-preview.png" id="headerLogo" class="themeLogo img-fluid w-100" alt="logo" />
            </a>
            <div class="nav-right justify-content-center" id="navbar">
                <ul class="navbar-nav position-relative d-lg-flex">
                    <li class="nav-item">
                        <a class="nav-link text-dark active" href="{{ route('user-side.home') }}">Home</a>
                    </li>
                    <li class="nav-item dropdown-tgl">
                        <a class="nav-link text-dark" href="javascript:void(0)">Auction</a>
                        <ul class="sub-menu">
                            <li><a href="{{ route('browse-bid') }}">browse bid</a></li>
                            <li><a href="./bid-history.html">bid history</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="contact.html">Contact</a>
                    </li>
                </ul>
            </div>

            @if (Auth::check())
                <!-- إذا كان المستخدم مسجل الدخول -->
                <div class="col-4">
                    <div class="d-flex gap-2 nav-btn-group align-items-center justify-content-end">
                        <a href="{{ route('user.profile') }}" class="bg-transparent text-dark border-0 px-1">
                            <i class="fa fa-user"></i>
                        </a>
                        <button class="bg-transparent text-dark border-0"><i class="fa fa-heart"></i></button>
                    </div>
                </div>
            @else
                <!-- إذا لم يكن المستخدم مسجل الدخول -->
                <div class="d-flex gap-1 nav-btn-group align-items-center">
                    <a href="{{ route('user.login') }}" class="primary-btn">
                        Get Started
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="nav-right" data-bs-target="#navbar"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="toggle-menu-icon"><span></span><span></span><span></span><span></span></span>
                    </button>
                </div>
            @endif
        </div>
    </nav>
</header>
