@extends('user-side.components.app')

@section('content')
<style>
 /* Styling for carousel control buttons */
 .carousel-control-prev, .carousel-control-next {
        background-color: rgba(0, 0, 0, 0.5); /* Add dark background */
        border-radius: 50%; /* Make buttons circular */
        height: 50px;
        width: 50px;
        opacity: 0.7; /* Slight transparency */
        transition: opacity 0.3s ease; /* Smooth transition on hover */
        border: 2px solid #000; /* Dark border around buttons */
        margin: auto;
    }

    .carousel-control-prev-icon, .carousel-control-next-icon {
        background-color: black; /* Set icon color to black */
        width: 20px;
        height: 20px;
        border-radius: 50%;
    }

    .carousel-control-prev:hover, .carousel-control-next:hover {
        opacity: 1; /* Increase opacity on hover */
    }
</style>
<main id="main-content" class="position-relative">
    <div class="breadcrumb-main">
        <div class="container">
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('user-side.home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Bid Detail</li>
                </ol>
                <h1 class="breadcrumb-title">Bid Details & More</h1>
            </div>
        </div>
    </div>
    <section class="single-bid-product outer-gap">
        <div class="container">
            <div class="row gy-4 gy-md-5">
                <div class="col-lg-8">
                    <div id="auctionCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($auction->customsItems as $item)
                                @if($item->images && $item->images->isNotEmpty())
                                    @foreach ($item->images as $index => $image)
                                    <div class="carousel-item @if($index == 0) active @endif">
                                        <img src="{{ asset($image->image_url) }}" class="d-block w-100" alt="Image of {{ $item->item_name }}"
                                             style="height: 400px; object-fit: contain; max-width: 100%; margin: 0 auto;">
                                    </div>
                                @endforeach
                            @else
                                <p>No images available for this item.</p>
                            @endif
                        @endforeach
                    </div>
                    <!-- Controls for next/prev -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#auctionCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#auctionCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>


    <div class="col-lg-4">
        <div class="product-bid-widget h-100">
            <h3 class="title">{{ $auction->auction_name }}</h3>
            <ul class="list-unstyled mb-4">
                <li class="d-flex justify-content-between mb-3">
                    <span>Start Bid</span>
                    <span>${{ number_format($auction->starting_price, 2) }}</span>
                </li>
                <li class="d-flex justify-content-between mb-3">
                    <span>Latest Bid</span>
                    <span>${{ number_format($auction->highestBid()?->bid_amount ?? $auction->starting_price, 2) }}</span>
                </li>
                <li class="d-flex justify-content-between mb-3">
                    <span>Total Bids</span>
                    <span>{{ $totalBids }}</span>
                </li>
                <li class="d-flex justify-content-between mb-3">
                    <span>Minimum Bid</span>
                    <span>${{ number_format($minimumBid, 2) }}</span>
                </li>
            </ul>

            <div class="bid-controls">
                @if(Auth::check())
                    @if($auction->status === 'ended')
                        <div class="text-center">
                            <span class="badge bg-danger text-white p-3">Ended</span>
                        </div>
                        @elseif($auction->status === 'pending')
                        <div class="text-center">
                            <span class="badge bg-warning text-white p-3">Coming Soon ...</span>
                        </div>
                    @else
                        <div class="d-flex align-items-center justify-content-between gap-3 mb-3">
                            <div class="bid-amount-wrapper d-flex align-items-center bg-light rounded">
                                <button type="button" class="btn btn-decrease px-3 py-2 border-0">
                                    <i class="fas fa-minus"></i>
                                </button>

                                <input type="number"
                                       id="bidAmount"
                                       class="form-control border-0 text-center bg-transparent"
                                       style="width: 120px; border-radius: 10px;"
                                       value="{{ number_format($auction->highestBid()?->bid_amount + $minimumBid, 2) }}"
                                       step="{{ $minimumBid }}"
                                       min="{{ number_format($auction->highestBid()?->bid_amount + $minimumBid, 2) }}">

                                <button type="button" class="btn btn-increase px-3 py-2 border-0" id="up">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <button type="button" id="bidButton" class="btn btn-primary w-100 py-2 rounded">
                            BID NOW
                        </button>

                        <p id="errorMessage" class="text-danger mt-2 mb-0" style="display: none;"></p>
                    @endif
                @else
                    <a href="{{ route('user.login') }}" class="btn btn-primary w-100 py-2 rounded">
                        Login to Bid
                    </a>
                @endif
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="product-detail-wrapper">
            <ul class="nav nav-tabs d-none d-md-flex" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">
                        Home
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">
                        Profile
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">
                        Contact
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="return-policy-tab" data-bs-toggle="tab" data-bs-target="#return-policy-tab-pane" type="button" role="tab" aria-controls="return-policy-tab-pane" aria-selected="false">
                        Return Policy
                    </button>
                </li>
            </ul>

            <div class="tab-content accordion" id="myTabContent">
                <!-- Home Tab -->
                <div class="tab-pane fade show active accordion-item" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                    <h2 class="accordion-header d-md-none" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Home
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show d-md-block" aria-labelledby="headingOne" data-bs-parent="#myTabContent">
                        <div class="accordion-body">
                            <!-- Product Stats -->
                            <div class="d-flex flex-wrap product-disc-stats">
                                <div class="p-2 p-sm-3 border border-opacity-10 flex-grow-1">
                                    <h5 class="mb-1">Vehicle Status</h5>
                                    <p>{{ $auction->customsItems->first()->vehicle_status }}</p>
                                </div>
                                <div class="p-2 p-sm-3 border border-opacity-10 flex-grow-1">
                                    <h5 class="mb-1">Storage Location</h5>
                                    <p>{{ $auction->customsItems->first()->storage_location }}</p>
                                </div>
                                <div class="p-2 p-sm-3 border border-opacity-10 flex-grow-1">
                                    <h5 class="mb-1">Brand</h5>
                                    <p>{{ $auction->customsItems->first()->brand->brand_name ?? 'No Brand Found' }}</p>
                                </div>
                                <div class="p-2 p-sm-3 border border-opacity-10 flex-grow-1">
                                    <h5 class="mb-1">Category</h5>
                                    <p>{{ $auction->customsItems->first()->category->category_name ?? 'No Category Found' }}</p>
                                </div>

                            </div>
                            <h4 class="mb-3">
                                {{ $auction->customsItems->first()->item_description }}
                            </h4>
                        </div>
                    </div>
                </div>



                <!-- Profile Tab -->
                <div class="tab-pane fade accordion-item" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                    <h2 class="accordion-header d-md-none" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Profile
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse d-md-block" aria-labelledby="headingTwo" data-bs-parent="#myTabContent">
                        <div class="accordion-body">
                            <!-- Table for Profile Information -->
                            <div class="table-responsive">
                                <table class="table bid-history m-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Personal Info</th>
                                            <th scope="col">Country</th>
                                            <th scope="col">Place Bid</th>
                                            <th scope="col">Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <img src="assets/images/avatar-5.png" class="dashboard-avatar" alt="avatar" />
                                                    <p>Rozzy Nomad</p>
                                                </div>
                                            </td>
                                            <td>Canada</td>
                                            <td>$225</td>
                                            <td>10 Minute Ago</td>
                                        </tr>
                                        <!-- More rows as needed -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Tab -->
                <div class="tab-pane fade accordion-item" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                    <h2 class="accordion-header d-md-none" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Contact
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse d-md-block" aria-labelledby="headingThree" data-bs-parent="#myTabContent">
                        <div class="accordion-body">
                            <!-- Contact Info Table -->
                            <table class="table seller-info">
                                <tbody>
                                    <tr>
                                        <td><h6>Name</h6><p>Rozzy Nomad</p></td>
                                        <td><h6>Product Sell</h6><p>60</p></td>
                                    </tr>
                                    <!-- More rows as needed -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Return Policy Tab -->
                <div class="tab-pane fade accordion-item" id="return-policy-tab-pane" role="tabpanel" aria-labelledby="return-policy-tab" tabindex="0">
                    <h2 class="accordion-header d-md-none" id="headingFour">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            Return Policy
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse d-md-block" aria-labelledby="headingFour" data-bs-parent="#myTabContent">
                        <div class="accordion-body">
                            <h4 class="mb-3">Hassle-free and easy return</h4>
                            <p class="mb-2">Id diam maecenas ultricies mi eget mauris pharetra...</p>
                            <p>Purus gravida quis blandit turpis cursus in hac...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bidAmount  = document.getElementById('bidAmount');
        const bidButton  = document.getElementById('bidButton');
        const errorMessage = document.getElementById('errorMessage');
        const decreaseBtn  = document.querySelector('.btn-decrease');
        const increaseBtn  = document.querySelector('.btn-increase');
        const up           = document.getElementById('up');

        @if(Auth::check() && $auction->status !== 'ended')
            const minimumBid     = {{ $minimumBid }};
            const highestBid     = {{ $auction->highestBid()?->bid_amount ?? $auction->starting_price }};
            const insuranceFee   = {{ $auction->insurance_fee }};
            const insuranceBalance = {{ Auth::user()->insurance_balance }};
            let currentBid       = highestBid + minimumBid;

            function formatNumber(num) {
                return parseFloat(num).toFixed(2);
            }

            function isMultiple(value, multiple) {
                return (value - highestBid) % multiple === 0;
            }

            function updateBidDisplay(value) {
                currentBid = parseFloat(value);
                bidAmount.value = formatNumber(currentBid);

                if (!isMultiple(currentBid, minimumBid)) {
                    errorMessage.textContent = `The bid must be a multiple of $${formatNumber(minimumBid)}.`;
                    errorMessage.style.display = 'block';
                    bidButton.disabled = true;
                } else if (currentBid < highestBid + minimumBid) {
                    errorMessage.textContent = `Minimum bid must be $${formatNumber(highestBid + minimumBid)}.`;
                    errorMessage.style.display = 'block';
                    bidButton.disabled = true;
                } else {
                    errorMessage.style.display = 'none';
                    bidButton.disabled = false;
                }
            }

            decreaseBtn.addEventListener('click', function() {
                if (currentBid > highestBid + minimumBid) {
                    updateBidDisplay(currentBid - minimumBid);
                }
            });

            increaseBtn.addEventListener('click', function() {
                updateBidDisplay(currentBid + minimumBid);
            });

            bidAmount.addEventListener('input', function() {
                const manualBid = parseFloat(bidAmount.value);
                if (!isNaN(manualBid)) {
                    updateBidDisplay(manualBid);
                }
            });

            bidButton.addEventListener('click', function() {
                const currentBidValue = parseFloat(bidAmount.value);

                if (currentBidValue >= highestBid + minimumBid && isMultiple(currentBidValue, minimumBid)) {
                    // إرسال طلب AJAX (Fetch) إلى السيرفر
                    fetch('{{ route('auction.placeBid', $auction->id) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ bid: currentBidValue })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success){
                            alert(`Your bid of $${formatNumber(currentBidValue)} has been placed.`);
                            location.reload();
                        } else {
                            // إذا كانت الرسالة Insufficient insurance balance => أظهر SweetAlert
                            if (data.message === 'Insufficient insurance balance.') {
                                Swal.fire({
                                icon: 'info',                                 // يمكنك اختيار error / warning / success / info
                                title: 'Your Next Great Deal Awaits!',
                                html: `
                                    <p style="font-size: 0.95rem; color: #2c3e50;">
                                    Top up now to keep bidding and secure your winning chance.
                                    </p>
                                    <p style="margin-top: 8px; font-size: 0.9rem; color: #16a085;">
                                    Don’t miss out on great deals — recharge and win!
                                    </p>
                                    <p style="margin-top: 10px; color: #16a085;">
                                    Secure your next bid with a simple click!
                                    </p>
                                `,
                                background: '#fefefe',                         // لون الخلفية
                                showCancelButton: true,
                                confirmButtonText: 'Recharge & Win',
                                cancelButtonText: 'Maybe Later',
                                confirmButtonColor: '#27ae60',                 // لون زر التأكيد
                                cancelButtonColor: '#e74c3c',                  // لون زر الإلغاء
                                customClass: {
                                    popup: 'animated fadeInDown faster'          // إن كنت تستعمل Animate.css أو ما شابه
                                }
                                }).then((result) => {
                                if (result.isConfirmed) {
                                    const requiredAmount = {{ $auction->insurance_fee }}; // قيمة المبلغ من السيرفر
                                    @php
                                    session(['required_amount' => $auction->insurance_fee]);
                                @endphp
                                    window.location.href =  `{{ route('auction.stripePayment') }}`;
                                }
                                });
                            } else {
                                // أي رسالة خطأ أخرى
                                errorMessage.textContent = data.message;
                                errorMessage.style.display = 'block';
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        errorMessage.textContent = 'An error occurred while placing your bid.';
                        errorMessage.style.display = 'block';
                    });
                }
            });

            updateBidDisplay(currentBid);
        @endif
    });
</script>


@endsection

@section('styles')
<style>
.carousel-control-prev, .carousel-control-next {
    background-color: rgba(0, 0, 0, 0.6) !important;
    border-radius: 50% !important;
    height: 50px !important;
    width: 50px !important;
    opacity: 0.8 !important;
    transition: opacity 0.3s ease, transform 0.2s !important;
    border: none !important;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3) !important;
}

.carousel-control-prev:hover, .carousel-control-next:hover {
    opacity: 1 !important;
    transform: scale(1.1) !important;
}

.carousel-control-prev-icon, .carousel-control-next-icon {
    background-color: white !important;
    width: 20px !important;
    height: 20px !important;
    border-radius: 50% !important;
    box-shadow: none !important;
}

.bid-amount-wrapper {
    background-color: #f8f9fa;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.btn-decrease, .btn-increase {
    background-color: #007bff;
    color: white;
    border-radius: 5px;
    width: 40px;
    height: 40px;
}

.btn-decrease:hover, .btn-increase:hover {
    background-color: #0056b3;
}

.btn-primary {
    background-color: #28a745;
    border-radius: 5px;
    font-size: 16px;
    transition: background-color 0.3s;
}

.btn-primary:hover {
    background-color: #218838;
}

#errorMessage {
    font-size: 14px;
    font-weight: bold;
    color: #e74c3c;
}
</style>
@endsection
