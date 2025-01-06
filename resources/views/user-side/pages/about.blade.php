@extends('user-side.components.app')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
<style>
    .hero-section {
        background: linear-gradient(135deg, #1a237e 0%, #0d47a1 100%);
        padding: 100px 0;
        color: white;
    }

    a {
    text-decoration: none;
}

    .feature-card {
        border: none;
        transition: transform 0.3s;
        height: 100%;
    }

    .feature-card:hover {
        transform: translateY(-10px);
    }

    .section-divider {
        height: 5px;
        width: 80px;
        background: #1a237e;
        margin: 20px auto;
    }

    .mission-card {
        border-right: 4px solid #1a237e;
        height: 100%;
    }

    .vision-card {
        border-left: 4px solid #1a237e;
        height: 100%;
    }

    .story-section {
        background: url('/api/placeholder/1920/400') center/cover;
        position: relative;
    }

    .story-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.7);
    }

    .story-content {
        position: relative;
        z-index: 1;
    }

    .developer-section {
        background: #f8f9fa;
    }

    .developer-img {
        border-radius: 50%;
        border: 5px solid #1a237e;
    }

    .help-card {
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .help-icon {
        font-size: 2.5rem;
        color: #1a237e;
        margin-bottom: 1rem;
    }

    .cta-section {
        background: linear-gradient(135deg, #0d47a1 0%, #1a237e 100%);
    }

    .footer {
        background: #0a1929;
    }
    @media (max-width: 768px) {
        .hero-section {
            padding: 50px 0;
        }

        .display-4 {
            font-size: 2.5rem;
        }

        .mission-card, .vision-card {
            margin-bottom: 1rem;
        }

        .help-card {
            margin-bottom: 1rem;
        }
    }

    @media (max-width: 576px) {
        .developer-img {
            max-width: 200px;
            margin: 0 auto;
        }
    }
    </style>

<main id="main-content" class="position-relative">
    <!-- Hero Section -->
<section class="hero-section text-center">
    <div class="container">
        <h1 class="display-4 mb-4">Welcome to Mazadna</h1>
        <div class="section-divider"></div>
        <p class="lead">The first platform in Jordan specializing in auctions for goods confiscated by Jordanian customs</p>
    </div>
</section>

<!-- Mission & Vision -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="mission-card p-4 bg-white shadow-sm">
                    <h3 class="text-primary mb-3">Our Mission</h3>
                    <p>Our mission is to provide a user-friendly and secure platform that allows everyone to participate in auctions easily and confidently.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="vision-card p-4 bg-white shadow-sm">
                    <h3 class="text-primary mb-3">Our Vision</h3>
                    <p>Our vision is to become the leading online auction platform in the Middle East, known for transparency, trust, and innovation.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Story Section -->
<section class="story-section py-5 text-white">
    <div class="container story-content">
        <h2 class="text-center mb-4">Our Story</h2>
        <div class="section-divider"></div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <p class="text-center">The idea for Mazadna was born when we noticed the difficulty in accessing confiscated goods and the lack of digital platforms to streamline the process.</p>
            </div>
        </div>
    </div>
</section>

<!-- Developer Section -->
<section class="developer-section py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-4 text-center">
                <img src="{{ asset('user-side/assets/images/WhatsApp Image 2024-09-20 at 21.40.25_77e9e67d.jpg') }}"  alt="Developer" class="developer-img img-fluid mb-4">
            </div>
            <div class="col-md-8">
                <h3 class="text-primary">Developer - Sohiub Batienh</h3>
                <p>A Full Stack Web Developer specializing in building innovative digital solutions. With Mazadna, I envisioned creating a platform that redefines how auctions are conducted in Jordan.</p>
            </div>
        </div>
    </div>
</section>

<!-- Help Section -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">How Can We Help You?</h2>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="help-card p-4 text-center">
                    <div class="help-icon">🔒</div>
                    <h4>Security</h4>
                    <p>Your data and transactions are protected</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="help-card p-4 text-center">
                    <div class="help-icon">⚡</div>
                    <h4>Ease of Use</h4>
                    <p>User-friendly interface</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="help-card p-4 text-center">
                    <div class="help-icon">👥</div>
                    <h4>Accessibility</h4>
                    <p>Bid anytime, anywhere</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="help-card p-4 text-center">
                    <div class="help-icon">✨</div>
                    <h4>Transparency</h4>
                    <p>Clear and reliable auction process</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section py-5 text-white text-center">
    <div class="container">
        <h2 class="mb-4">Join Us on Our Journey</h2>
        <a href="#" class="btn btn-light btn-lg rounded-pill px-5">Get Started</a>
    </div>
</section>

</main>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
@endsection

@section('footer')
<!-- Footer Section -->
<footer>
  <!-- Footer Content -->
</footer>
@endsection
