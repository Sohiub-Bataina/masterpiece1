@extends('user-side.components.app')

@section('content')

<main id="main-content" class="position-relative">
    <!-- Breadcrumb Section -->
    <div class="breadcrumb-main">
        <div class="container">
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">BROWSE BID</li>
                </ol>
                <h1 class="breadcrumb-title">Available items & bids</h1>
            </div>
        </div>
    </div>

    <!-- Auction Filter and Products Section -->
    <section class="outer-gap">
        <div class="container">
            <div class="row gy-4">
                <div class="col-xl-3">
                    <button class="primary-btn d-xl-none mb-3" type="button" data-bs-toggle="collapse"
                        data-bs-target="#auction-filter-collapse" aria-expanded="false"
                        aria-controls="auction-filter-collapse">
                        filter product
                    </button>
                    <div class="collapse d-xl-block" id="auction-filter-collapse">
                        <div class="row gy-4">
                            <div class="col-sm-6 col-xl-12">
                                <div class="auction-wrapper p-3">
                                    <form action="{{ route('auction.search') }}" method="GET">
                                    <input type="search" name="query" class="form-control" placeholder="Search" value="{{ request()->query('query') }}">
                                    <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                                </form>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-12">
                                <div class="auction-wrapper p-3">
                                    <select name="shorting" class="form-control bg-transparent border-0">
                                        <option value="">Default Shorting</option>
                                        <option value="">Price Low to Heigh</option>
                                        <option value="">Price Heigh to Low </option>
                                    </select>
                                </div>
                            </div>


                            <!-- Filter by Price Section -->
                            <div class="col-sm-6 col-xl-12">
                                <div class="auction-wrapper">
                                    <h4 class="mb-3">Filter by price</h4>
                                    <div class="filter-price">
                                        <div class="price-field">
                                            <input type="range" min="100" max="500" value="100" id="lower">
                                            <input type="range" min="100" max="500" value="500" id="upper">
                                        </div>
                                        <div class="price-wrap">
                                            <div class="price-wrap-1">
                                                <input id="one">
                                                <label for="one">$</label>
                                            </div>
                                            <div class="price-wrap-2">
                                                <input id="two">
                                                <label for="two">$</label>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="primary-btn small-btn">Filter</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Auction Cards Section -->
                <!-- Auction Cards Section -->
<div class="col-xl-9">
    <div class="auction-card-small">
        <div class="row gy-4 justify-content-center">
            @foreach($activeAuctions as $auction)
                <div class="col-sm-6 col-lg-4">
                    <div class="auction-card">
                        <div class="card-image">
                            <img src="{{ asset($auction->main_image ?? 'user-side/assets/images/default-auction.png') }}" alt="auction-card-img">
                            <div class="timer-wrapper">
                                <div class="timer-inner" id="timer-{{ $auction->id }}">
                                    <!-- عداد المؤقت -->
                                </div>
                            </div>
                        </div>
                        <div class="card-content">
                            <a href="{{ route('auction-details', $auction->id) }}" class="card-title">{{ $auction->auction_name }}</a>
                            <p>Current bid <span>${{ $auction->highestBid()?->bid_amount ?? $auction->starting_price }}</span></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('auction-details', $auction->id) }}" class="primary-btn">Bid Now</a>
                                <button class="like-btn"><i class="fa-regular fa-heart"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach



                        </div>
                    </div>
                </div>
                >
            </div>
        </div>
    </section>

</main>
@endsection
<script>
    // تمرير البيانات من Laravel إلى JavaScript
    var auctions = @json($activeAuctions);
  </script>
