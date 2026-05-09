<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Reset Password - Event Booker</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/fav.png') }}">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    <!-- Vendor CSS -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Main Template CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('css/night-mode.css') }}" rel="stylesheet">
</head>
<body class="h-100">

<div class="form-wrapper">
    <div class="app-form">

        <!-- Left Green Sidebar (same as forgot password page) -->
        <div class="app-form-sidebar" style="background: #7cb342;">
            <div class="sidebar-sign-logo text-center pt-5">
                <img src="{{ asset('images/logo-white.svg') }}" alt="Event Booker" style="max-width: 180px;">
            </div>
            <div class="sign_sidebar_text text-white text-center px-4 mt-5">
                <h1 class="text-white">The Easiest Way to Create Events and Sell More Tickets Online</h1>
            </div>
        </div>

        <!-- Right Form Area -->
        <div class="app-form-content">
            <div class="container h-100">
                <div class="row justify-content-center align-items-center h-100">
                    <div class="col-lg-5 col-md-7 col-sm-9">

                        <h3 class="mb-4 text-center">Reset Your Password</h3>

                        @if (session('status'))
                            <div class="alert alert-success text-center">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <!-- Hidden token - passed from controller -->
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="mb-4">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control form-control-lg"
                                       value="{{ $email ?? old('email') }}" readonly autocomplete="username">
                                @error('email')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label">New Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control form-control-lg"
                                       required autocomplete="new-password">
                                @error('password')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Confirm New Password <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control form-control-lg"
                                       required autocomplete="new-password">
                            </div>

                            <button type="submit" class="btn btn-success btn-lg w-100 mb-4"
                                    style="background:#7cb342; border:none;">
                                Reset Password
                            </button>
                        </form>

                        <div class="text-center mt-4">
                            <a href="{{ route('login') }}" class="text-success fw-500">
                                <i class="fas fa-arrow-left me-2"></i> Back to Sign In
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
<script src="{{ asset('js/night-mode.js') }}"></script>

</body>
</html>
