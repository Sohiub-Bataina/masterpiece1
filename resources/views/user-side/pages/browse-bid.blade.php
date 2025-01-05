@extends('user-side.components.app')

@section('content')
<style>
    /* تصميم نموذج البحث */
.search-form {
    display: flex;
    align-items: center;
    position: relative;
}

.search-input {
    width: 100%;
    padding: 0.5rem 2.5rem 0.5rem 1rem; /* إضافة مساحة للأيقونة */
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 1rem;
}

.search-button {
    position: absolute;
    right: 10px; /* موقع الأيقونة */
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #888;
    font-size: 1.25rem;
    cursor: pointer;
    padding: 0;
}

.search-button:hover {
    color: var(--primary-color); /* لون عند التحويم */
}

/* تحسين الحدود */
.search-input:focus {
    outline: none;
    border-color: var(--primary-color); /* لون الحدود عند التركيز */
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* تحسين الشكل */
}

    /* تأكد من أن النصوص داخل القائمة المنسدلة تظهر بالكامل */
.dropdown-select {
    padding-right: 3rem; /* مسافة كافية بين النص والأيقونة */
    width: 100%; /* عرض الحقل بالكامل */
    white-space: nowrap; /* منع النص من الانكسار */
    overflow: hidden; /* منع التمرير الأفقي */
    text-overflow: ellipsis; /* عرض النص المقطوع بعلامة ... إذا كان طويلاً */
    font-size: 1rem; /* حجم خط مناسب */
}

 /* تصميم الأيقونة */
 .dropdown-icon {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    font-size: 1rem;
    color: var(--text-secondary);
    pointer-events: none; /* منع التفاعل مع الأيقونة */
    transition: transform 0.3s ease-in-out; /* حركة سلسة */
}

/* حركة الأيقونة عند الضغط فقط */
.dropdown-select:focus + .dropdown-icon {
    transform: translateY(-50%) rotate(180deg); /* تدوير الأيقونة عند الضغط */
}


</style>

<main id="main-content" class="position-relative">
    <!-- Breadcrumb Section -->
    <div class="breadcrumb-main">
        <div class="container">
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('user-side.home') }}">Home</a></li>
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
                                    <form action="{{ route('auction.search') }}" method="GET" class="search-form" style="position: relative;">
                                        <input type="search" name="query" class="form-control search-input" placeholder="Search" value="{{ request()->query('query') }}">
                                        <button type="submit" class="search-button">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-12">
                                <div class="auction-wrapper p-3">
                                    <form action="{{ route('auction.search') }}" method="GET" style="position: relative;">
                                        <select name="vehicle_status" class="form-control bg-transparent border-0 dropdown-select" onchange="this.form.submit()" >
                                            <option value="">Filter by Vehicle Status</option>
                                            <option value="drivable" {{ request('vehicle_status') === 'drivable' ? 'selected' : '' }}>Drivable</option>
                                            <option value="non_drivable" {{ request('vehicle_status') === 'non_drivable' ? 'selected' : '' }}>Non Drivable</option>
                                        </select>
                                        <i class="fa-solid fa-angle-down dropdown-icon"></i>
                                        <input type="hidden" name="query" value="{{ request('query') }}">
                                        <input type="hidden" name="storage_location" value="{{ request('storage_location') }}">
                                        <input type="hidden" name="brand_id" value="{{ request('brand_id') }}">
                                    </form>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-12">
                                <div class="auction-wrapper p-3" >
                                    <form action="{{ route('auction.search') }}" method="GET" style="position: relative;">
                                        <select name="storage_location" class="form-control bg-transparent border-0 dropdown-select" onchange="this.form.submit()" >
                                            <option value="">Filter by Storage Location</option>
                                            <option value="Amman Customs" {{ request('storage_location') === 'Amman Customs' ? 'selected' : '' }}>Amman Customs</option>
                                            <option value="Zarqa Free Zone" {{ request('storage_location') === 'Zarqa Free Zone' ? 'selected' : '' }}>Zarqa Free Zone</option>
                                            <option value="Aqaba" {{ request('storage_location') === 'Aqaba' ? 'selected' : '' }}>Aqaba</option>
                                        </select>
                                        <i class="fa-solid fa-angle-down dropdown-icon"></i>
                                        <input type="hidden" name="query" value="{{ request('query') }}">
                                        <input type="hidden" name="vehicle_status" value="{{ request('vehicle_status') }}">
                                        <input type="hidden" name="brand_id" value="{{ request('brand_id') }}">
                                    </form>
                                </div>
                            </div>


                            <div class="col-sm-6 col-xl-12">
                                <div class="auction-wrapper p-3">
                                    <form action="{{ route('auction.search') }}" method="GET" style="position: relative;">
                                        <select name="brand_id" class="form-control bg-transparent border-0 dropdown-select" onchange="this.form.submit()">
                                            <option value="">Filter by Brand</option>
                                            @foreach(\App\Models\Brand::all() as $brand)
                                                <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->brand_name }}</option>
                                            @endforeach
                                        </select>
                                        <i class="fa-solid fa-angle-down dropdown-icon"></i>
                                        <input type="hidden" name="query" value="{{ request('query') }}">
                                        <input type="hidden" name="vehicle_status" value="{{ request('vehicle_status') }}">
                                        <input type="hidden" name="storage_location" value="{{ request('storage_location') }}">
                                    </form>
                                </div>
                            </div>
                            <!-- Filter by Price Section -->
                            <div class="col-sm-6 col-xl-12">
                                <div class="auction-wrapper p-3">
                                    <h4 class="mb-3">Filter by Price</h4>
                                    <div class="filter-price">
                                        <!-- Slider to select price range -->
                                        <div class="price-slider">
                                            <label for="priceRange">Price Range:</label>
                                            <div class="d-flex justify-content-between">
                                                <span id="minPriceLabel">${{ $minPrice }}</span>
                                                <span id="maxPriceLabel">${{ $maxPrice }}</span>
                                            </div>
                                            <input type="range" min="{{ $minPrice }}" max="{{ $maxPrice }}" value="{{ $minPrice }}" id="priceRange" name="price" class="slider">
                                        </div>
                                        <div class="price-value mt-3">
                                            <!-- Display value below the slider -->
                                            <div class="d-flex justify-content-between">
                                                <input id="priceValue" value="{{ $minPrice }}" class="price-input" type="number" min="{{ $minPrice }}" max="{{ $maxPrice }}">
                                                <label for="priceValue">$</label>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Submit the filter form -->
                                    <form action="{{ route('auction.search') }}" method="GET" id="filterForm">
                                        <input type="hidden" name="price" id="hiddenPrice" value="{{ $minPrice }}">
                                        <button type="submit" class="primary-btn small-btn mt-3">Filter</button>
                                    </form>
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
                                <button class="like-btn" onclick="toggleWishlist({{ $auction->id }})">
                                    <i class="fa-regular fa-heart" id="heart-icon-{{ $auction->id }}"></i>
                                </button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                        </div>
                    </div>
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
  <script>
    function toggleWishlist(auctionId) {
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
                document.getElementById(`heart-icon-${auctionId}`).classList.replace('fa-regular', 'fa-solid');
            } else if (data.status === 'removed') {
                document.getElementById(`heart-icon-${auctionId}`).classList.replace('fa-solid', 'fa-regular');
            }
            updateWishlistCount(data.wishlistCount);
        })
        .catch(error => console.error('Error:', error));
}

function updateWishlistCount(count) {
    document.getElementById('wishlist-count').innerText = count;
}
  </script>
  <script>
    // Get the slider element and the input field for value display
    const priceRange = document.getElementById('priceRange');
    const priceValue = document.getElementById('priceValue');
    const hiddenPrice = document.getElementById('hiddenPrice');
    const minPriceLabel = document.getElementById('minPriceLabel');
    const maxPriceLabel = document.getElementById('maxPriceLabel');

    // Set initial value of the priceValue input to the initial slider value
    priceValue.value = priceRange.value;
    hiddenPrice.value = priceRange.value;

    // Event listener to update value in the input and hidden field when slider is moved
    priceRange.addEventListener('input', function() {
        // Update displayed value and hidden field for form submission
        priceValue.value = priceRange.value;
        hiddenPrice.value = priceRange.value;
    });

    // Handle input field change
    priceValue.addEventListener('input', function() {
        // Ensure the value is within the allowed range
        if (priceValue.value < {{ $minPrice }}) priceValue.value = {{ $minPrice }};
        if (priceValue.value > {{ $maxPrice }}) priceValue.value = {{ $maxPrice }};

        priceRange.value = priceValue.value;  // Sync slider with input field
        hiddenPrice.value = priceValue.value; // Update hidden field for form submission
    });
</script>
