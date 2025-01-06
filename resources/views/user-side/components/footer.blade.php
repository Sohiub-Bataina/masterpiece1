<!-- Footer Start -->
<footer>
  <div class="footer-top bg-dark inner-gap">
    <div class="container">
      <div class="row gy-4 gy-lg-3">
        <div class="col-md-12 col-lg-4">
          <div class="footer-disc">
            <a href="{{ route('user-side.home') }}" class="footer-logo">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('assets/img/logos/Screenshot_2024-11-24_152203-removebg-preview (1).png') }}"
                         alt="Mazadna Logo"
                         style="height: 40px; width: auto;">
                    <span class="ms-0.7 font-weight-bold text-white" style="font-size: 1.9rem;">azadna</span>
                </div>

            </a>
            <p>
              Unlock treasures through exhilarating auctions. Your gateway to rare finds and captivating experiences awaits.
            </p>
            <a href="mailto:info@bidzone.com" class="h4 fw-normal text-white">sohiubbatina@gmail.com</a>
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
        <div class="col-sm-6 col-md-3 col-lg-2">
            <div class="footer-widget">
              <h5 class="widget-title">Follow Us</h5>
              <div class="social-links">
                <a href="https://www.facebook.com" target="_blank" class="me-2">
                  <i class="fab fa-facebook fa-lg text-white"></i>
                </a>
                <a href="https://www.twitter.com" target="_blank" class="me-2">
                  <i class="fab fa-twitter fa-lg text-white"></i>
                </a>
                <a href="https://www.instagram.com" target="_blank">
                  <i class="fab fa-instagram fa-lg text-white"></i>
                </a>
              </div>
              <p class="mt-3 text-white" style="font-size: 0.8rem;">© 2025 Mazadna. All rights reserved.</p>
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
