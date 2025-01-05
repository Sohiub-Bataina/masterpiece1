<!DOCTYPE html>
<html lang="en" id="theme" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('assets') }}/img/logos/Screenshot 2024-11-24 152203.png"/>
    <title>Log In</title>
    <link rel="stylesheet" href="{{ asset('user-side/assets/css/all.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('user-side/assets/css/bootstrap.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('user-side/assets/css/style.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('user-side/assets/css/responsive.css') }}" type="text/css" />
    <style>
        .error {
            color: red;
        }

        #login-wrapper {
            background-size: cover;
            background-position: center;
            height: 100vh;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="login-wrapper" id="login-wrapper" style="background-image: url('{{ asset('user-side/assets/images/login-bg.svg') }}')">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="form-wrapper text-center">
                        <a class="d-inline-block mb-2" href="{{ route('user-side.home') }}">
                            <img src="{{ asset('assets/img/logos/image-removebg-preview.png') }}" class="themeLogo img-fluid" alt="logo">
                        </a>
                        <h2 class="display-6 fw-bold mb-3">Log In</h2>
                        <form action="{{ route('check.login') }}" method="POST" id="loginForm">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email">Email*</label>
                                        <input type="email" id="email" name="email" class="form-control" placeholder="name@mail.com" required>
                                        <span class="error" id="emailError"></span>
                                        @error('email')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group formPassword">
                                        <label for="password">Password*</label>
                                        <div style="position: relative">
                                            <input type="password" id="password" name="password" class="form-control" placeholder="******" required>
                                            <span class="toggle-password" id="togglePassword">👁️</span>
                                        </div>
                                        <span class="error" id="passwordError"></span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="primary-btn w-100" type="submit" id="submitBtn">Log In</button>
                                </div>
                                <div class="col-12">
                                    <p>Don't have an account? <a href="{{ route('signup') }}">Create an account</a></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('user-side/assets/js/jquery.min.js') }}"></script>
    <script>
        // Password toggle visibility
        document.getElementById("togglePassword").addEventListener("click", function() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.type === "password" ? "text" : "password";
            passwordInput.type = type;
            this.textContent = type === "password" ? "👁️" : "👁️‍🗨️";
        });
    </script>
</body>
</html>
