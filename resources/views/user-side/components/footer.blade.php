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
              <li><a href="{{ url('about') }}">About</a></li>
              <li><a href="{{ url('contact') }}">Contact</a></li>
            </ul>
          </div>
        </div>
        <div class="col-sm-6 col-md-3 col-lg-2">
          <div class="footer-widget">
            <h5 class="widget-title">Navigation</h5>
            <ul class="ps-3 widget-links">
              <li><a href="{{ url('customer-profile') }}">My Account</a></li>
              <li><a href="{{ url('browse-bid') }}">Browse Bid</a></li>
              <li><a href="{{ url('wishlist') }}">Wish list</a></li>
              <li><a href="{{ url('user/bids') }}">View My Bids</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
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
