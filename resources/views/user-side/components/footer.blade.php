<!-- Footer Start -->
<footer>
  <div class="footer-top bg-dark inner-gap">
    <div class="container">
      <div class="row gy-4 gy-lg-3">
        <div class="col-md-12 col-lg-4">
          <div class="footer-disc">
            <a href="{{ url('/') }}" class="footer-logo">
              <img src="{{ asset('assets/images/logo-white.svg') }}" id="footerLogo" class="fThemeLogo img-fluid" alt="logo" />
            </a>
            <p>
              Unlock treasures through exhilarating auctions. Your gateway to rare finds and captivating experiences awaits.
            </p>
            <a href="mailto:info@bidzone.com" class="h4 fw-normal text-white">support@example.com</a>
          </div>
        </div>
        <div class="col-sm-6 col-md-3 col-lg-2">
          <div class="footer-widget">
            <h5 class="widget-title">Sitemap</h5>
            <ul class="ps-3 widget-links">
              <li><a href="{{ url('blog') }}">Blog</a></li>
              <li><a href="{{ url('faq') }}">FAQS</a></li>
              <li><a href="{{ url('about') }}">About</a></li>
              <li><a href="{{ url('contact') }}">Contact</a></li>
            </ul>
          </div>
        </div>
        <div class="col-sm-6 col-md-3 col-lg-2">
          <div class="footer-widget">
            <h5 class="widget-title">Categories</h5>
            <ul class="ps-3 widget-links">
              <li><a href="{{ url('browse-bid') }}">Music</a></li>
              <li><a href="{{ url('browse-bid') }}">Jewellery</a></li>
              <li><a href="{{ url('browse-bid') }}">Real Estate</a></li>
              <li><a href="{{ url('browse-bid') }}">Vehicle</a></li>
              <li><a href="{{ url('browse-bid') }}">Clothes</a></li>
              <li><a href="{{ url('browse-bid') }}">Sports</a></li>
            </ul>
          </div>
        </div>
        <div class="col-sm-6 col-md-3 col-lg-2">
          <div class="footer-widget">
            <h5 class="widget-title">Navigation</h5>
            <ul class="ps-3 widget-links">
              <li><a href="{{ url('my-account') }}">My Account</a></li>
              <li><a href="{{ url('bid-history') }}">Bid History</a></li>
              <li><a href="{{ url('checkout') }}">Checkout</a></li>
              <li><a href="{{ url('payment') }}">Payment</a></li>
              <li><a href="{{ url('winner') }}">Winner</a></li>
            </ul>
          </div>
        </div>
        <div class="col-sm-6 col-md-3 col-lg-2">
          <div class="footer-widget">
            <h5 class="widget-title">Legal</h5>
            <ul class="ps-3 widget-links">
              <li><a href="{{ url('privacy') }}">Privacy Policy</a></li>
              <li><a href="{{ url('cookies-policy') }}">Cookies Policy</a></li>
              <li><a href="{{ url('terms-of-service') }}">Terms Of Service</a></li>
            </ul>
          </div>
        </div>
      </div>
      <hr class="my-4 my-lg-5 border-white" />
      <div class="d-flex flex-wrap gap-4 justify-content-center justify-content-xl-between align-items-center">
        <ul class="footer-social-links">
          <li><a href="javascript:void(0)"><i class="fa fa-facebook-f"></i></a></li>
          <li><a href="javascript:void(0)"><i class="fa fa-twitter"></i></a></li>
          <li><a href="javascript:void(0)"><i class="fa fa-pinterest-p"></i></a></li>
          <li><a href="javascript:void(0)"><i class="fa fa-instagram"></i></a></li>
        </ul>
        <div class="bid-number">
          <h2><span>1,50,000</span> Bids</h2>
          <h2><span>10,376</span> Members</h2>
          <h2><span>8942</span> Feedbacks</h2>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-bottom py-2 py-md-4 bg-light">
    <p class="text-dark text-center">
      ©
      <script>
        document.write(new Date().getFullYear());
      </script>
      BidZone - All Rights Reserved.
    </p>
  </div>
</footer>
<!-- Footer End -->
<!-- JavaScript Libraries -->
<script src="{{ asset('user-side/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('user-side/assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('user-side/assets/js/swiper.min.js') }}"></script>
<script src="{{ asset('user-side/assets/js/custom.js') }}"></script>


<script>
  var swiper = new Swiper(".categorySwiper", {
    spaceBetween: 32,
    autoplay: { delay: 1000 },
    breakpoints: {
      450: { slidesPerView: 2 },
      768: { slidesPerView: 3 },
      992: { slidesPerView: 4 },
      1400: { slidesPerView: 6 }
    },
    navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
  });

  const mySwiper = new Swiper(".banner-slider", {
    effect: "cards",
    grabCursor: true,
    slidesPerView: 1,
    autoplay: { delay: 2000 },
  });

  var x = 0;
  var y = 1;
  var currentActiveSlide = $(".swiper-slide-active .banner-card img").attr("src");
  $("#current-image").css("background-image", `url(${currentActiveSlide})`);

  mySwiper.on("slideChange", function (e) {
    x = e.activeIndex;
    if (y <= x) {
      var currentActiveSlide = $(".swiper-slide-next .banner-card img").attr("src");
      $("#current-image").css("background-image", `url(${currentActiveSlide})`);
    } else {
      var currentActiveSlide = $(".swiper-slide-prev .banner-card img").attr("src");
      $("#current-image").css("background-image", `url(${currentActiveSlide})`);
    }
    y = x;
  });
</script>
