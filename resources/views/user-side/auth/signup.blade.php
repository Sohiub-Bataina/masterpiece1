<!DOCTYPE html>
<html lang="en" id="theme" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('assets') }}/img/logos/Screenshot 2024-11-24 152203.png"/>
    <title>Sign Up</title>
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
                        <h2 class="display-6 fw-bold mb-3">Sign Up</h2>
                        <form action="{{ route('register') }}" method="POST" id="signupForm">
                            @csrf
                            <!-- Step 1 -->
                            <div id="step1">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="full_name">Full Name*</label>
                                            <input type="text" id="full_name" name="full_name" class="form-control" placeholder="Full Name" required>
                                            <span class="error" id="fullNameError"></span>
                                        </div>
                                    </div>
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
                                        <div class="form-group">
                                            <label for="phone_number">Phone Number*</label>
                                            <input type="text" id="phone_number" name="phone_number" class="form-control" placeholder="079xxxxxxx" required>
                                            <span class="error" id="phoneError"></span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="button" class="btn btn-primary" id="nextStep1" disabled>Next</button>
                                    </div>
                                    <div class="col-12">
                                        <p>Already have an account? <a href="{{ route('user.login') }}">Log In</a></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 2 -->
                            <div id="step2" style="display:none;">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="gender">Gender*</label>
                                            <select id="gender" name="gender" class="form-control" required>
                                                <option value="">Select Gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                            <span class="error" id="genderError"></span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="residence">Residence*</label>
                                            <input type="text" id="residence" name="residence" class="form-control" placeholder="City" required>
                                            <span class="error" id="residenceError"></span>
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
                                        <div class="form-group formPassword">
                                            <label for="password_confirmation">Confirm Password*</label>
                                            <div style="position: relative">
                                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="******" required>
                                                <span class="toggle-password" id="toggleConfirmPassword">👁️</span>
                                            </div>
                                            <span class="error" id="confirmPasswordError"></span>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-4">
                                        <button class="primary-btn w-100" type="submit" id="submitBtn" disabled>Submit</button>
                                    </div>
                                    <div class="col-12">
                                        <p>Don't have an account? <a href="{{ route('user.login') }}">Log In</a></p>
                                    </div>
                                    <div class="col-12">
                                        <button type="button" class="btn btn-secondary" id="prevStep2">Previous</button>
                                    </div>
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
        // Step 1 validation
        const fullNameInput = document.getElementById('full_name');
        const emailInput = document.getElementById('email');
        const phoneInput = document.getElementById('phone_number');
        const nextStepButton = document.getElementById('nextStep1');
        const logo = document.querySelector('.themeLogo');
        const signUpText = document.querySelector('h2.display-6');

        let isEmailValid = false; // Flag to track email validity

        function validateStep1() {
            const fullNameValid = fullNameInput.value.length >= 6;
            const emailValid = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(emailInput.value);
            const phoneValid = /^[0-9]{9}$/.test(phoneInput.value.replace('+962', '').trim());

            document.getElementById('fullNameError').textContent = fullNameValid ? '' : 'Full name must be at least 6 characters';
            document.getElementById('emailError').textContent = emailValid ? '' : 'Invalid email format';
            document.getElementById('phoneError').textContent = phoneValid ? '' : 'Phone number must be valid';

            // Enable/disable next button based on full form validation
            nextStepButton.disabled = !(fullNameValid && emailValid && phoneValid && isEmailValid);
        }

        fullNameInput.addEventListener('input', validateStep1);
        emailInput.addEventListener('input', validateStep1);
        phoneInput.addEventListener('input', validateStep1);

        // Check if email exists via AJAX
        $('#email').on('input', function() {
            const email = $(this).val();

            $.ajax({
                url: '{{ route('check.email') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    email: email
                },
                success: function(response) {
                    if (response.exists) {
                        $('#emailError').text('The email has already been taken');
                        $('#nextStep1').prop('disabled', true); // Disable next button if email exists
                        isEmailValid = false; // Set email as invalid
                    } else {
                        $('#emailError').text('');
                        isEmailValid = true; // Set email as valid
                        validateStep1(); // Revalidate form if email is not taken
                    }
                }
            });
        });

        $('#nextStep1').click(function() {
            $('#step1').hide();
            $('#step2').show();
            logo.style.display = 'none';
            signUpText.style.display = 'none';
        });

        // Step 2 validation
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');
        const submitBtn = document.getElementById('submitBtn');
        const genderInput = document.getElementById('gender');
        const residenceInput = document.getElementById('residence');

        function validateStep2() {
            const passwordValid = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*.])[A-Za-z\d!@#$%^&*.]{6,}$/.test(passwordInput.value);
            const confirmPasswordValid = passwordInput.value === confirmPasswordInput.value;
            const allFieldsFilled = genderInput.value && residenceInput.value && passwordInput.value && confirmPasswordInput.value;

            document.getElementById('passwordError').textContent = passwordValid ? '' : 'Password must contain at least 6 characters, one uppercase, one lowercase, one number, and one symbol';
            document.getElementById('confirmPasswordError').textContent = confirmPasswordValid ? '' : 'Passwords do not match';
            document.getElementById('genderError').textContent = genderInput.value ? '' : 'Gender is required';
            document.getElementById('residenceError').textContent = residenceInput.value ? '' : 'Residence is required';

            submitBtn.disabled = !(passwordValid && confirmPasswordValid && allFieldsFilled);
        }

        passwordInput.addEventListener('input', validateStep2);
        confirmPasswordInput.addEventListener('input', validateStep2);
        genderInput.addEventListener('change', validateStep2);
        residenceInput.addEventListener('input', validateStep2);

        // Password toggle visibility
        document.getElementById("togglePassword").addEventListener("click", function() {
            const type = passwordInput.type === "password" ? "text" : "password";
            passwordInput.type = type;
            this.textContent = type === "password" ? "👁️" : "👁️‍🗨️";
        });

        document.getElementById("toggleConfirmPassword").addEventListener("click", function() {
            const type = confirmPasswordInput.type === "password" ? "text" : "password";
            confirmPasswordInput.type = type;
            this.textContent = type === "password" ? "👁️" : "👁️‍🗨️";
        });

        // Previous step navigation
        $('#prevStep2').click(function() {
            $('#step2').hide();
            $('#step1').show();
            logo.style.display = 'inline-block';
            signUpText.style.display = 'inline-block';
        });
    </script>


</body>
</html>
