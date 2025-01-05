@foreach($pendingAuctions as $auction)
    <div class="col-sm-6 col-lg-4 col-xl-3">
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
                <a href="{{ route('auction-details', $auction->id) }}" class="card-title">{{ $auction->title }}</a>
                <p>Starting Price <span>${{ number_format($auction->starting_price, 2) }}</span></p>
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('auction-details', $auction->id) }}" class="primary-btn">More Details</a>
                    <button class="like-btn" onclick="toggleWishlist({{ $auction->id }})">
                        <i class="fa-regular fa-heart" id="heart-icon-{{ $auction->id }}"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endforeach
