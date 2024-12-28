@extends('user-side.components.app')

@section('content')
<!-- Main Content Start !-->
<main id="main-content" class="position-relative">

  <!-- Banner Section -->
  <section
    class="banner overflow-hidden"
    id="current-image"
   style="background-image: url()"
>
    <div class="container position-relative">
        <div class="row align-items-center justify-content-center gy-4">
            <div class="col-xl-7">
                <div class="banner-left">
                    <h1 class="banner-title">
                        Join exclusive auction & Get the finest.
                    </h1>
                    <div class="input-group banner-search-box">
                        <form action="{{ route('auction.search') }}" method="GET" style="display: flex; width: 100%;">
                            <input
                                type="search"
                                name="query"
                                class="form-control"
                                placeholder="I’m Looking for..."
                            />
                            <button type="submit" class="primary-btn">Search</button>
                        </form>
                    </div>

                </div>
            </div>

                  <div class="col-11 col-md-8 col-xl-5">
                      <div class="swiper banner-slider">
                          <div class="swiper-wrapper">
                              @foreach($auctions as $auction)
                                  <div class="swiper-slide">
                                      <div class="banner-card position-relative">
                                          <!-- عرض صورة المزاد أو صورة افتراضية إذا لم تكن موجودة -->
                                          <img src="{{ asset($auction->main_image ?? 'user-side/assets/images/default-auction.png') }}" alt="banner-bid" />

                                          <div class="banner-card-disc">
                                              <a href="{{ url('bid-detail', $auction->id) }}">{{ $auction->auction_name }}</a>
                                              <p>${{ $auction->minimum_price }}</p>
                                          </div>
                                      </div>
                                  </div>
                              @endforeach
                          </div>
                      </div>
                  </div>
              </div>

        </div>
    </div>
</section>


  <!-- Live Auction Section -->
  <section class="outer-gap">
    <div class="container">
        <h2 class="section-title">
            {{ $activeAuctions->isNotEmpty() ? $activeAuctions[0]->title : 'No Active Auctions Available' }}
        </h2>
        <div class="row gy-4">
          <!-- المزاد الكبير -->
          <div class="col-lg-6">
              @if($activeAuctions->isNotEmpty())
                  <div class="auction-card">
                      <div class="card-image left-card-image">
                          <img src="{{ asset($activeAuctions[0]->main_image ?? 'user-side/assets/images/default-auction.png') }}" class="h-100 w-100" alt="auction-card-img">
                          <div class="timer-wrapper">
                              <div class="timer-inner" id="timer-{{ $activeAuctions[0]->id }}">
                                  <!-- عداد المؤقت -->
                              </div>
                          </div>
                      </div>
                      <div class="card-content">
                          <h4>{{ $activeAuctions[0]->auction_name }}</h4>
                          <h4>{{ $activeAuctions[0]->title }}</h4>
                          <p>Current bid <span>${{ $activeAuctions[0]->highestBid()?->bid_amount ?? $activeAuctions[0]->starting_price }}</span></p>

                          <div class="d-flex justify-content-between align-items-center">
                              <a href="{{ route('auction-details', $activeAuctions[0]->id) }}" class="primary-btn">Bid Now</a>
                              <button class="like-btn"><i class="fa-regular fa-heart"></i></button>
                          </div>
                      </div>
                  </div>
              @endif
          </div>

          <!-- المزادات الصغيرة -->
          <div class="col-lg-6">
              <div class="auction-card-small">
                  <div class="row gy-3">
                      @foreach($activeAuctions->skip(1) as $auction)
                          <div class="col-md-6">
                              <div class="auction-card">
                                  <div class="card-image">
                                      <img src="{{ asset($auction->main_image ?? 'user-side/assets/images/default-auction.png') }}" class="img-fluid" alt="auction-card-img">
                                      <div class="timer-wrapper">
                                          <div class="timer-inner" id="timer-{{ $auction->id }}">
                                              <!-- عداد المؤقت -->
                                          </div>
                                      </div>
                                  </div>
                                  <div class="card-content">
                                      <h4>{{ $auction->auction_name }}</h4>
                                      <h4>{{ $auction->title }}</h4>
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

          <!-- زر عرض المزيد -->
          <div class="col-12 text-center">
              {{-- <a href="{{ route('auctions.list') }}" class="primary-btn dark-btn mt-3 mt-md-5">VIEW ALL BID</a> --}}
          </div>
      </div>


    </div>
</section>




  <!-- Upcoming Auctions Section -->
<!-- Upcoming Auctions Section -->
<section class="outer-gap inner-gap bg-light">
  <div class="container">
      <h2 class="section-title">Upcoming Auctions</h2>
      <div class="row gy-4">
          <!-- Drivable Vehicles -->
          <div class="col-lg-6">
              <div class="upcoming-auction position-relative bg-orange">
                  <h3 class="text-white">Drivable Vehicles</h3>
                  @foreach ($auctions->where('vehicle_status', 'drivable')->take(3) as $auction)
                      <div class="row gy-4 mb-4">
                          <div class="col-md-12 text-white position-relative">
                              <h3 class="upcoming-title line-clamp line-clamp-2">{{ $auction->title }}</h3>
                              <p class="line-clamp line-clamp-4">{{ $auction->description }}</p>
                              <!-- Bid Now Form -->
                              <form action="{{ route('auction.details') }}" method="POST">
                                  @csrf
                                  <input type="hidden" name="id" value="{{ $auction->id }}">
                                  <button type="submit" class="primary-btn light-btn">Bid Now</button>
                              </form>
                          </div>
                      </div>
                  @endforeach
                  <div class="text-center mt-4">
                      <!-- View All Drivable Auctions Form -->
                      <form action="{{ route('browse-bid') }}" method="GET">
                          <input type="hidden" name="vehicle_status" value="drivable">
                          <button type="submit" class="primary-btn">View All Drivable Auctions</button>
                      </form>
                  </div>
              </div>
          </div>

          <!-- Non-Drivable Vehicles -->
          <div class="col-lg-6">
              <div class="upcoming-auction position-relative bg-blue">
                  <h3 class="text-white">Non-Drivable Vehicles</h3>
                  @foreach ($auctions->where('vehicle_status', 'non_drivable')->take(3) as $auction)
                      <div class="row gy-4 mb-4">
                          <div class="col-md-12 text-white position-relative">
                              <h3 class="upcoming-title line-clamp line-clamp-2">{{ $auction->title }}</h3>
                              <p class="line-clamp line-clamp-4">{{ $auction->description }}</p>
                              <!-- Bid Now Form -->
                              <form action="{{ route('auction.details') }}" method="POST">
                                  @csrf
                                  <input type="hidden" name="id" value="{{ $auction->id }}">
                                  <button type="submit" class="primary-btn light-btn">Bid Now</button>
                              </form>
                          </div>
                      </div>
                  @endforeach
                  <div class="text-center mt-4">
                      <!-- View All Non-Drivable Auctions Form -->
                      <form action="{{ route('browse-bid') }}" method="GET">
                          <input type="hidden" name="vehicle_status" value="non_drivable">
                          <button type="submit" class="primary-btn">View All Non-Drivable Auctions</button>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>
</section>






  <!-- Recent Auctions Section -->
  <section class="recent-auction outer-gap">
    <div class="container">
      <h2 class="section-title">Recent Auctions</h2>
      <div class="auction-card-small">
        <div class="row gy-4 justify-content-center">
          <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="auction-card">
              <div class="card-image">
                <img src="https://theme.bitrixinfotech.com/bidzone/assets/images/recent-auction-1.png" alt="auction-card-img" />
                <div class="timer-wrapper">
                  <div class="timer-inner"></div>
                </div>
              </div>
              <div class="card-content">
                <a href="https://theme.bitrixinfotech.com/bidzone/bid-detail.html" class="card-title">Mendinib top violin from best artist</a>
                <div class="d-flex justify-content-between align-items-center">
                  <p class="p-0">Current bid <span>589.00$</span></p>
                  <button class="like-btn">
                    <i class="fa fa-heart"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <!-- More recent auction cards... -->
        </div>
      </div>
    </div>
  </section>

</main>
@endsection
<script>
  // تمرير البيانات من Laravel إلى JavaScript
  var auctions = @json($activeAuctions);
</script>

@section('footer')
<!-- Footer Section -->
<footer>
  <!-- Footer Content -->
</footer>

@endsection

@section('scripts')

@endsection
