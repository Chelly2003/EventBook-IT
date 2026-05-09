@extends('frontend.dashboard.master')

@section('title', 'Conversion Setup')

@section('content')
<div class="wrapper wrapper-body">
    <div class="dashboard-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-main-title">
                        <h3><i class="fa-solid fa-square-plus me-3"></i>Conversion Setup</h3>
                    </div>
                </div>

                <!-- Add Tracking Button -->
                <div class="col-md-12">
                    <div class="main-card mt-5">
                        <div class="dashboard-wrap-content p-4">
                            <h5 class="mb-4">Setup Visitor & Conversion Tracking</h5>
                        <!--    <div class="d-md-flex flex-wrap align-items-center">
                                <div class="dashboard-date-wrap">
                                    <div class="form-group">
                                        <div class="relative-input position-relative">
                                            <input class="form-control h_40" type="text" placeholder="Search by referral source" value="">
                                            <i class="uil uil-search"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs ms-auto mt_r4">
                                    <button class="main-btn btn-hover h_40 w-100" data-bs-toggle="modal" data-bs-target="#trackingModal">Add Tracking</button>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dynamic Referral Analytics -->
                @foreach($referrals as $referral)
                <div class="col-md-12">
                    <div class="main-card mt-5">
                        <div class="contact-list">
                            <div class="top d-flex flex-wrap justify-content-between align-items-center p-4 border_bottom">
                                <div class="icon-box">
                                    <span class="icon-big icon">
                                        <i class="fa-solid fa-chart-column"></i>
                                    </span>
                                    <h5 class="font-18 mb-1 mt-1 f-weight-medium">{{ $referral->heard_from ?: 'Other' }}</h5>
                                    <p class="text-gray-50 m-0"><span class="visitor-date-time">Total Bookings: {{ $referral->total }}</span></p>
                                </div>
                            </div>
                            <div class="bottom d-flex flex-wrap justify-content-between align-items-center p-4">
                                <div class="icon-box ">
                                    <span class="icon">
                                        <i class="fa-solid fa-group-arrows-rotate"></i>
                                    </span>
                                    <p>Applicable for</p>
                                    <h6 class="coupon-status">All Events</h6>
                                </div>
                                <div class="icon-box">
                                    <span class="icon">
                                        <i class="fa-regular fa-address-card"></i>
                                    </span>
                                    <p>Total Bookings</p>
                                    <h6 class="coupon-status">{{ $referral->total }}</h6>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: {{ ($referral->total / $referrals->sum('total')) * 100 }}%;" aria-valuenow="{{ $referral->total }}" aria-valuemin="0" aria-valuemax="{{ $referrals->sum('total') }}"></div>
                                    </div>
                                </div>
                                <div class="icon-box">
                                    <span class="icon">
                                        <i class="fa-regular fa-calendar-days"></i>
                                    </span>
                                    <p>Last Updated</p>
                                    <h6 class="coupon-status">N/A</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
           <div class="col-md-12">
                    <div class="main-card mt-5 p-4" style="max-width: 500px; margin: 0 auto;">
                        <canvas id="referralPieChart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('referralPieChart').getContext('2d');
    const referralPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($referrals->pluck('heard_from')) !!},
            datasets: [{
                data: {!! json_encode($referrals->pluck('total')) !!},
                backgroundColor: [
                    '#3b82f6', // Facebook
                    '#ec4899', // Instagram
                    '#14b8a6', // TikTok
                    '#facc15', // Friend
                    '#f97316', // Poster
                    '#8b5cf6', // Website
                    '#9ca3af'  // Other
                ],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        font: {
                            size: 14
                        }
                    }
                },
                tooltip: {
                    enabled: true,
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            let value = context.raw || 0;
                            return label + ': ' + value;
                        }
                    }
                }
            }
        }
    });
</script>
            </div>
        </div>
    </div>
</div>


<script src="js/vertical-responsive-menu.min.js"></script>
<script src="js/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/OwlCarousel/owl.carousel.js"></script>
<script src="vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
<script src="js/custom.js"></script>
<script src="js/datepicker.min.html"></script>
<script src="js/i18n/datepicker.en.html"></script>
<script src="js/night-mode.js"></script>

@endsection



