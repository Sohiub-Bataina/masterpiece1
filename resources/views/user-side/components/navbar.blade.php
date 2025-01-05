<header class="bg-white">
    <style>
        .dropdown-menu {
        min-width: 200px;
        padding: 0.5rem 0;
        border: none;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        border-radius: 0.5rem;
        margin-top: 0.5rem;
    }

    .dropdown-item {
        padding: 0.7rem 1.5rem;
        color: #333;
        transition: all 0.3s ease;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
        color: #007bff;
    }

    .dropdown-item i {
        width: 20px;
        text-align: center;
    }

    .dropdown-divider {
        margin: 0.5rem 0;
    }

    /* User Icon Styles */
    .fa-user {
        font-size: 1.2rem;
    }

    /* Hover effect for the user icon */
    .user-dropdown > button:hover {
        color: #007bff !important;
    }

    /* Make sure dropdown is visible */
    .dropdown-menu.show {
        display: block;
        transform: translate3d(0px, 38px, 0px) !important;
    }
        </style>
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
            <div class="col-4">
                <div class="d-flex gap-2 nav-btn-group align-items-center justify-content-end">
                    <div class="dropdown user-dropdown">
                        <button class="btn btn-link text-dark border-0 p-0 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('user.profile') }}">
                                    <i class="fas fa-user-circle me-2"></i> Profile
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('user-side.auth.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>

                    <button class="bg-transparent text-dark border-0" onclick="location.href='/wishlist'">
                        <i class="fas fa-heart"></i>
                        <span id="wishlist-count">{{ Auth::check() ? Auth::user()->wishlist->count() : 0 }}</span>
                    </button>

                    <button class="navbar-toggler" type="button" data-bs-toggle="nav-right" data-bs-target="#navbar"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="toggle-menu-icon"><span></span><span></span><span></span><span></span></span>
                    </button>
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

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
