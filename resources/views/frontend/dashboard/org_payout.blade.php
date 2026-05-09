@extends('frontend.dashboard.master')

@section('title', 'Payouts')

@section('content')

<div class="wrapper wrapper-body">
    <div class="dashboard-body">
        <div class="container-fluid">
{{-- Display Success/Error Messages --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('info'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        {{ session('info') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
            <div class="d-main-title mb-4">
                <h3><i class="fa-solid fa-credit-card me-3"></i>Payouts</h3>
            </div>

            <!-- Revenue Summary Card -->
            <div class="main-card mt-4">
                <div class="dashboard-wrap-content p-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="dashboard-report-card purple">
                                <div class="card-content">
                                    <span class="card-title fs-6">Total Revenue Earned</span>
                                    <span class="card-sub-title fs-3">KES {{ number_format($totalRevenue ?? 0, 2) }}</span>
                                    <p class="mt-2 text-muted">This is the total money collected from ticket sales of your events.</p>
                                </div>
                                <div class="card-media">
                                    <i class="fa-solid fa-money-bill"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="main-card mt-4">
                <div class="dashboard-wrap-content p-4">

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                        <h5 class="mb-0">Your Payout Methods</h5>

                        <button class="main-btn btn-hover h_40"
                                data-bs-toggle="modal"
                                data-bs-target="#payoutModal">
                            <i class="uil uil-plus me-2"></i>Add Payout Method
                        </button>
                    </div>

                    <!-- Show Saved Methods -->
                    @if($methods->isNotEmpty())
                        <div class="row g-4">
                            @foreach($methods as $method)
                                <div class="col-lg-4 col-md-6">
                                    <div class="bank-card p-4 rounded shadow-sm">
                                        @if($method->type === 'mpesa')
                                            <div class="d-flex align-items-center mb-3">
                                                <i class="uil uil-mobile-android-alt text-success fs-4 me-3"></i>
                                                <div>
                                                    <h6 class="mb-1">M-Pesa</h6>
                                                    <small class="text-muted">
                                                        Phone: +254{{ $method->mpesa_phone }}
                                                    </small>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="card-actions mt-3">
                                            <form action="{{ route('organiser.payout.destroy', $method->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-danger bg-transparent border-0 p-0"
                                                        onclick="return confirm('Delete this payout method?')">
                                                    <i class="fa-solid fa-trash-can"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-light text-center py-5">
                            No payout methods added yet.
                        </div>
                    @endif

                    <!-- Withdraw Button -->
                 <!-- Withdraw Section -->
@if($methods->isNotEmpty() && ($totalRevenue ?? 0) > 0)
    <div class="mt-5">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Withdraw Funds</h5>
                <p class="text-muted">Total Available: <strong>KES {{ number_format($totalAvailable ?? 0, 2) }}</strong></p>

                <form action="{{ route('organiser.payout.request') }}" method="POST">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">Amount to Withdraw (KES)</label>
                          <input type="number"
       name="amount"
       class="form-control form-control-lg"
       min="10"
       max="{{ $totalAvailable ?? 0 }}"
       placeholder="e.g. 200"
       required>
<small class="text-muted">Minimum: KES 10 | Maximum: KES {{ number_format($totalAvailable ?? 0, 2) }}</small>
                        </div>

                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit"
                                    class="btn btn-success btn-lg w-100"
                                    onclick="return confirm('Confirm withdrawal?')">
                                <i class="fa-solid fa-wallet me-2"></i>
                                Withdraw
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@else
    <div class="alert alert-info mt-4">
        You need to add a payout method and have some revenue before you can withdraw.
    </div>
@endif
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
