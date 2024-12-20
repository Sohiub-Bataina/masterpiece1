@props(['activePage'])

<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0 d-flex text-wrap align-items-center" href="{{ route('dashboard') }}">
            <img src="{{ asset('assets/img/logos/Screenshot_2024-11-24_152203-removebg-preview (1).png')}}" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-2 font-weight-bold text-white">Mazadna</span>
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse w-auto max-height-vh-100" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <!-- Dashboard Link -->
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'dashboard' ? ' active bg-gradient-primary' : '' }}" href="{{ route('dashboard') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <!-- User Management Link -->
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'user-management' ? ' active bg-gradient-primary' : '' }}" href="{{ route('user-management') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="aside_li fas fa-users"></i>
                    </div>
                    <span class="nav-link-text ms-1">User Management</span>
                </a>
            </li>

            <!-- Tables Link -->
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'tables' ? ' active bg-gradient-primary' : '' }}" href="{{ route('tables') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">table_view</i>
                    </div>
                    <span class="nav-link-text ms-1">products</span>
                </a>
            </li>
            <!-- Auction Link -->
            <li class="nav-item">
            <a class="nav-link text-white {{ $activePage == 'auctions' ? ' active bg-gradient-primary' : '' }}" href="{{ route('auctions.index') }}">

                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">table_view</i>
                    </div>
                    <span class="nav-link-text ms-1">auctions</span>
                </a>
            </li>
            <!-- Category Link -->
            <li class="nav-item">
            <a class="nav-link text-white {{ $activePage == 'category' ? ' active bg-gradient-primary' : '' }}" href="{{ route('category.index') }}">

                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">table_view</i>
                    </div>
                    <span class="nav-link-text ms-1">category</span>
                </a>
            </li>
            <!-- Brand Link -->
            <li class="nav-item">
            <a class="nav-link text-white {{ $activePage == 'brand' ? ' active bg-gradient-primary' : '' }}" href="{{ route('brand.index') }}">
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="material-icons opacity-10">table_view</i>
                </div>
                <span class="nav-link-text ms-1">Brand</span>
              </a>
            </li>

        </ul>
    </div>
    
    <!-- Sidenav Footer with User Info -->
    <div class="sidenav-footer mx-3" style="margin-top: 3rem !important;">
    <div class="card card-background shadow-none card-background-mask-secondary" id="sidenavCard">
    <div class="full-background" style="background-image: url('{{ asset('assets/img/white-curved.jpg') }}')"></div>
        <div class="card-body text-start p-3 w-100">
            <div class="docs-info">
                <!-- Display User Information -->
                <h6 class="text-white up mb-0">{{ Auth::user()->full_name }}</h6>
                <p class="text-xs font-weight-bold">{{ Auth::user()->role }}</p>
                <a href="{{ route('user-profile') }}" class="btn btn-white btn-sm w-100 mb-0">Profile</a>
            </div>
        </div>
    </div>
    <form method="POST" action="{{ route('logout') }}" id="logout-form" class="d-inline">
    @csrf
    <button type="submit" class="btn bg-gradient-primary mt-3 w-100">Sign Out
    </button>
</form>
    
</div>
</aside>
