@extends('user-side.components.app')

@section('content')
<main id="main-content" class="position-relative">
    <div class="breadcrumb-main">
        <div class="container">
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('user-side.home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Contact us</li>
                </ol>
                <h1 class="breadcrumb-title">Reach Out to us</h1>
            </div>
        </div>
    </div>
    <div class="inner-gap">
        <div class="container">
            <div class="row gy-4 gy-sm-4">
                <div class="col-lg-8">
                    <div class="contact-wrapper bg-wrapper">
                        <h4 class="fw-bold mb-3 text-capitalize">Get in touch</h4>
                        <form id="send-mail" method="POST" action="{{ route('send.mail') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name*</label>
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Your Name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email*</label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="your@email.com" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Message*</label>
                                        <textarea class="form-control" name="message" id="message" placeholder="Your Message" required></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="primary-btn btn-light" type="submit" id="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="contact-wrapper bg-orange text-white h-100">
                        <h4 class="fw-bold mb-4">Contact Details</h4>
                        <br><br>
                        <h5 class="d-flex gap-2 gap-sm-3 pb-2">
                            <i class="fa-solid fa-location-dot"></i>
                            Address
                        </h5>
                        <h6 class="fw-light">Amman , Jordan</h6>
                        <hr class="my-2 my-md-3">
                        <h5 class="d-flex gap-2 gap-sm-3 pb-2">
                            <i class="fa-solid fa-phone"></i>
                            Phone Number
                        </h5>
                        <h6 class="fw-light">+9627 9700 7135</h6>
                        <hr class="my-2 my-md-3">
                        <h5 class="d-flex gap-2 gap-sm-3 pb-2">
                            <i class="fa-solid fa-envelope"></i>
                            Email Address
                        </h5>
                        <h6 class="fw-light">sohiubbataina@gmail.com</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- SweetAlert Success Message -->
@if(session('success'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
   Swal.fire({
    icon: 'success',
    title: 'Thank you!',
    text: 'Your message has been sent successfully!',
    confirmButtonText: 'OK'
});
</script>
@endif

<!-- Main Content End !-->
<div class="aleart-box">
    <span class="aleart-text" id="alert-msg">This Field Required</span>
 </div>

@endsection

@section('footer')
<!-- Footer Section -->
<footer>
  <!-- Footer Content -->
</footer>
@endsection
