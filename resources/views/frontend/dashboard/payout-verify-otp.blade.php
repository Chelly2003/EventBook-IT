@extends('frontend.dashboard.master')

@section('title', 'Verify OTP')

@section('content')
<div class="wrapper wrapper-body">
    <div class="dashboard-body">
        <div class="container-fluid">
            <div class="main-card mt-4">
                <div class="dashboard-wrap-content p-4">
                    <h4>Verify OTP</h4>
                    <p class="mb-4">We sent a 6-digit OTP to your M-PESA phone. Enter it below to confirm your payout method.</p>

                    <form method="POST" action="{{ route('organiser.payout.verify-otp') }}">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="otp" class="form-label">OTP</label>
                            <input type="text" name="otp" class="form-control" maxlength="6" required autofocus>
                            @error('otp')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="main-btn btn-hover h_40 px-4">Verify & Save</button>
                    </form>
   <p class="mt-3">
    Didn't receive or expired?
    <form action="{{ route('organiser.payout.resend-otp') }}" method="POST" class="d-inline">
        @csrf
        <button type="submit" class="text-primary bg-transparent border-0 p-0">Resend OTP</button>
    </form>
</p>
                    <p class="mt-3 text-muted">
                        Didn't receive? Check your phone or contact support.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
