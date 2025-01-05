@extends('user-side.components.app')

@section('content')
<style>
    .breadcrumb-main {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 2rem 0;
        margin-bottom: 2rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .breadcrumb-title {
        font-size: 2rem;
        font-weight: 600;
        color: #2c3e50;
        margin: 0;
    }

    .breadcrumb-item a {
        color: #6c757d;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .breadcrumb-item a:hover {
        color: #007bff;
    }

    /* Auction Card Styles */
    .auction-card-small {
        margin-bottom: 5rem;
    }

    .auction-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
        height: 100%;
        margin-bottom: 1rem;
    }

    .auction-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    /* Image Styles */
    .card-image {
        position: relative;
        padding-top: 100%;
        overflow: hidden;
        background: #f8f9fa;
    }

    .card-image img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 10px;
        transition: transform 0.5s ease;
    }

    .auction-card:hover .card-image img {
        transform: scale(1.05);
    }


    /* Card Content Styles */
    .card-content {
        padding: 1.5rem;
        background: white;
    }

    .card-title {
        color: #2c3e50;
        font-size: 1.1rem;
        font-weight: 600;
        text-decoration: none;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 2.8em;
        line-height: 1.4;
        margin-bottom: 1rem;
        transition: color 0.3s ease;
    }

    .card-title:hover {
        color: #007bff;
    }

    .card-content p {
        color: #6c757d;
        margin-bottom: 1rem;
    }

    .card-content p span {
        color: #28a745;
        font-weight: 600;
        font-size: 1.1rem;
    }

    /* Button Styles */
    .primary-btn {
        background: #007bff;
        color: white;
        padding: 0.7rem 1.2rem;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s ease;
        font-weight: 500;
    }

    .primary-btn:hover {
        background: #0056b3;
        color: white;
    }

    .like-btn {
        background: none;
        border: none;
        padding: 0.5rem;
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    .like-btn:hover {
        transform: scale(1.2);
    }

    .fa-heart {
        color: #dc3545;
        font-size: 1.2rem;
    }

    /* Empty State Styles */
    .empty-state {
        background: white;
        border-radius: 15px;
        padding: 3rem 2rem;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        margin: 2rem 0;
    }

    .empty-state-icon {
        font-size: 3.5rem;
        color: #e0e0e0;
        margin-bottom: 1.5rem;
    }

    .empty-state-title {
        font-size: 1.5rem;
        color: #333;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .empty-state-text {
        color: #666;
        font-size: 1rem;
        max-width: 400px;
        margin: 0 auto;
        line-height: 1.6;
    }

    .start-shopping-btn {
        display: inline-block;
        background: #007bff;
        color: white;
        padding: 0.8rem 2rem;
        border-radius: 8px;
        text-decoration: none;
        margin-top: 1.5rem;
        transition: all 0.3s ease;
    }

    .start-shopping-btn:hover {
        background: #0056b3;
        color: white;
        transform: translateY(-2px);
    }
    </style>
<div class="breadcrumb-main">
    <div class="container">
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="{{ route('user-side.home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Wishlist</li>
            </ol>
            <h1 class="breadcrumb-title">Your Wishlist</h1>
        </div>
    </div>
</div>

<div class="container mt-4">
    <div class="auction-card-small">
        @if($wishlistItems->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="fa-regular fa-heart"></i>
            </div>
            <h3 class="empty-state-title">Your Wishlist is Empty</h3>
            <p class="empty-state-text">
                Discover amazing items and add them to your wishlist by clicking the heart icon on auction pages.
            </p>
            <a href="{{ route('user-side.home') }}" class="start-shopping-btn">
                Start Browsing
            </a>
        </div>
        @else
            <div class="row gy-4 justify-content-center">
                @foreach($wishlistItems as $item)
                <div class="col-sm-6 col-lg-4">
                    <div class="auction-card">
                        <div class="card-image">
                            <img src="{{ asset($item->auction->main_image ?? 'user-side/assets/images/default-auction.png') }}" alt="auction-card-img">
                            <div class="timer-wrapper">
                                <div class="timer-inner">
                                    <p id="timer-{{ $item->auction->id }}"></p>
                                </div>
                            </div>
                        </div>
                        <div class="card-content">
                            <a href="{{ route('auction-details', $item->auction->id) }}" class="card-title">{{ $item->auction->auction_name }}</a>
                            <p>Starting Price: <span>${{ $item->auction->starting_price }}</span></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('auction-details', $item->auction->id) }}" class="primary-btn">View Auction</a>
                                <button class="like-btn" onclick="toggleWishlist({{ $item->auction_id }}, this)">
                                    <i class="fa-solid fa-heart" id="heart-icon-{{ $item->auction->id }}"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<script>
    // تمرير قائمة المزادات الديناميكية من Blade إلى JavaScript
    const auctions = @json($wishlistItems->map(fn($item) => [
        'id' => $item->auction->id,
        'end_time' => $item->auction->end_time
    ]));

    // إعداد العدادات لكل مزاد
    $(document).ready(function () {
        auctions.forEach(function (auction) {
            var countDownDate = new Date(auction.end_time).getTime();
            var x = setInterval(function () {
                var now = new Date().getTime();
                var distance = countDownDate - now;

                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                var timerElement = document.getElementById('timer-' + auction.id);
                if (timerElement) {
                    timerElement.innerHTML = `<span>${days}D</span> : <span>${hours}H</span> : <span>${minutes}M</span> : <span>${seconds}S</span>`;
                }

                if (distance < 0) {
                    clearInterval(x);
                    if (timerElement) {
                        timerElement.innerHTML = "EXPIRED";
                    }
                }
            }, 1000);
        });
    });

    function toggleWishlist(auctionId, button) {
        // إرسال الطلب إلى السيرفر لإضافة أو إزالة العنصر من الأمنيات
        fetch(`/wishlist/toggle/${auctionId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'added') {
                // تغيير حالة القلب ليكون مملوء
                button.querySelector('i').classList.replace('fa-regular', 'fa-solid');
            } else if (data.status === 'removed') {
                // تغيير حالة القلب ليعود إلى الوضع العادي
                button.querySelector('i').classList.replace('fa-solid', 'fa-regular');
                location.reload(); // إعادة تحميل الصفحة بعد الإزالة
            }
            updateWishlistCount(data.wishlistCount);
        })
        .catch(error => console.error('Error:', error));
    }

    function updateWishlistCount(count) {
        document.getElementById('wishlist-count').innerText = count;
    }
</script>
@endsection
