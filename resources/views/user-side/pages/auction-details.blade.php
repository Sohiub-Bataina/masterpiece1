@extends('user-side.components.app')

@section('content')
<main id="main-content" class="position-relative">
    <div class="breadcrumb-main">
        <div class="container">
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('user-side.home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Bid Detail
                    </li>
                </ol>
                <h1 class="breadcrumb-title">Bid Details & More</h1>
            </div>
        </div>
    </div>

    <section class="single-bid-product outer-gap">
        <div class="container">
            <div class="row gy-4 gy-md-5">
                <div class="col-lg-8">
                    <div class="card-image">
                        <img src="{{ asset('assets/images/auction-card-1.png') }}" alt="auction-card-img" />
                        <div class="timer-wrapper">
                            <div class="timer-inner" id="auction-timer"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="product-bid-widget h-100">
                        <h3 class="title">{{ $auction->title }}</h3>
                        <ul>
                            <li><span>Start Bid</span><span>${{ number_format($auction->starting_price, 2) }}</span></li>
                            <li><span>Latest Bid</span><span>${{ number_format($auction->highestBid()?->bid_amount ?? $auction->starting_price, 2) }}</span></li>
                            <li><span>Total Bids</span><span>{{ $totalBids }}</span></li>
                        </ul>
                        <div class="d-flex flex-wrap justify-content-between gap-2">
                            <div class="item-quantity">
                                <span class="input-group-text decrement">
                                    <button  onclick="mines({{ $minimumBid }})">-</button>
                                </span>
                                <input type="number" id="myNumber" min="{{ $auction->highestBid()?->bid_amount ?? $auction->starting_price + $minimumBid }}" value="{{ $auction->highestBid()?->bid_amount ?? $auction->starting_price + $minimumBid }}" class="" />
                                <span class="input-group-text increment">
                                    <button  onclick="add({{ $minimumBid }})">+</button>
                                </span>
                            </div>
                            <a id="bidButton" href="#" class="primary-btn d-flex align-items-center" disabled>Bid Now</a>
                            <p id="errorMessage" class="text-danger" style="display:none;"></p>  <!-- الرسالة التي ستظهر في حالة الخطأ -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@section('footer')
<!-- Footer Section -->
<footer>
  <!-- Footer Content -->
</footer>
@endsection

@section('scripts')
<script>
    const bidButton = document.getElementById('bidButton');
    const myNumber = document.getElementById('myNumber');
    const errorMessage = document.getElementById('errorMessage');

    // الحصول على القيم من الـ PHP
    const startingPrice = {{ $auction->starting_price }};
    const minimumBid = {{ $minimumBid }};

    // دالة تقليل المبلغ
    function mines() {
        let currentBid = parseFloat(myNumber.value);
        if (currentBid > startingPrice) {
            myNumber.value = (currentBid - minimumBid).toFixed(2);
            checkBidAmount();
        }
    }

    // دالة زيادة المبلغ
    function add() {
        let currentBid = parseFloat(myNumber.value);
        myNumber.value = (currentBid + minimumBid).toFixed(2);
        checkBidAmount();
    }

    // دالة التحقق من صلاحية المبلغ
    function checkBidAmount() {
        let currentBid = parseFloat(myNumber.value);
        if (currentBid < startingPrice + minimumBid) {
            errorMessage.style.display = 'block';
            errorMessage.textContent = 'Bid must be at least $' + (startingPrice + minimumBid).toFixed(2);
            bidButton.setAttribute('disabled', true);
        } else {
            errorMessage.style.display = 'none';
            bidButton.removeAttribute('disabled');
        }
    }

    // التحقق الأولي عند تحميل الصفحة
    checkBidAmount();
</script>


@endsection
