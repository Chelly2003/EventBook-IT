<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Forgot Password - EventBook-IT</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="images/fav.png">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    <!-- Vendor CSS -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Main Template CSS -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">
    <link href="css/night-mode.css" rel="stylesheet">
</head>

<body class="h-100">

<div class="form-wrapper">
    <div class="app-form">

        <!-- Left Green Sidebar (exactly like your screenshot) -->
        <div class="app-form-sidebar" style="background: #7cb342;">
            <div class="sidebar-sign-logo text-center pt-5">
                <img src="images/logo-white.svg" alt="Event Booker" style="max-width: 180px;">
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
                        <div class="text-end mb-4">
                            <small>New to EventBook-IT? <a href="sign_up.html" class="text-success fw-500">Sign up</a></small>
                        </div>

                        <h3 class="mb-4 text-center">Forgot Your Password?</h3>

                      <form action="{{ route('password.email') }}" method="POST">
    @csrf
    <div class="mb-4">
        <label class="form-label">Your Email <span class="text-danger">*</span></label>
        <input type="email" name="email" class="form-control form-control-lg" placeholder="Enter your email" required>
        @error('email')
            <span class="text-danger small">{{ $message }}</span>
        @enderror
    </div>

    <button type="submit" class="btn btn-success btn-lg w-100 mb-4" style="background:#7cb342; border:none;">
        Send Reset Link
    </button>

    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger mt-3">{{ session('error') }}</div>
    @endif
</form>
                        <div class="text-center my-4">
                            <span class="text-muted">or</span>
                        </div>

                        <!-- Social Buttons (kept exactly like your sign-in page) -->
                        <div class="d-grid gap-3">
                            <button class="btn btn-outline-secondary btn-lg d-flex align-items-center justify-content-center">
                                <img src="https://www.google.com/favicon.ico" width="20" class="me-2" alt=""> Sign in with Google
                            </button>

                        </div>

                        <div class="text-center mt-4">
                            <a href="{{ route('login') }}">
                                <i class="fas fa-arrow-left me-2"></i> Back to Sign In
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reset Password Modal -->

<!-- Scripts -->
<script src="js/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="js/custom.js"></script>
<script src="js/night-mode.js"></script>

</body>

