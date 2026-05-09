@extends('frontend.dashboard.master')

@section('title', 'Dashboard')

@section('content')

<!-- Body Start -->
<div class="wrapper wrapper-body">
    <div class="dashboard-body">
        <div class="container-fluid">
            <div class="row">


                <div class="col-md-12">
                    <div class="main-card add-organisation-card p-4 mt-5">
                        <div class="ocard-left">
                            <div class="ocard-avatar">
                                <img src="{{ Auth::user()->avatar ?? 'images/profile-imgs/img-13.jpg' }}" alt="">
                            </div>
                            <div class="ocard-name">
                                <h5>{{ Auth::user()->name }}</h5>
                                <span>My Organisation</span>
                            </div>
                        </div>

                    </div>

                    <div class="main-card mt-4">
                        <div class="dashboard-wrap-content">
                            <div class="d-flex flex-wrap justify-content-between align-items-center p-4">
                                <div class="dashboard-date-wrap d-flex flex-wrap justify-content-between align-items-center">
                                    <div class="dashboard-date-arrows">
                                        <a href="#" class="before_date"><i class="fa-solid fa-angle-left"></i></a>
                                        <a href="#" class="after_date disabled"><i class="fa-solid fa-angle-right"></i></a>
                                    </div>
                                    <h5 class="dashboard-select-date">
                                        <span>{{ now()->startOfMonth()->format('jS F, Y') }}</span>
                                        -
                                        <span>{{ now()->endOfMonth()->format('jS F, Y') }}</span>
                                    </h5>
                                </div>
                                <div class="rs">
                                    <div class="dropdown dropdown-text event-list-dropdown">
                                        <button class="dropdown-toggle event-list-dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span>Selected Events ({{ $events->count() }})</span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            @foreach($events as $event)
                                                <li><a class="dropdown-item" href="#">{{ $event->title }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="dashboard-report-content">
                                <div class="row">
                                    <!-- Revenue -->
                                    <div class="col-xl-4 col-lg-6 col-md-6">
                                        <div class="dashboard-report-card purple">
                                            <div class="card-content">
                                                <span class="card-title fs-6">Revenue (KSH)</span>
                                                <span class="card-sub-title fs-3">KSH{{ number_format($totalRevenue, 2) }}</span>
                                                <div class="d-flex align-items-center">
                                                    <span><i class="fa-solid fa-arrow-trend-up"></i></span>
                                                    <span class="text-Light font-12 ms-2 me-2">0.00%</span>
                                                    <span class="font-12 color-body text-nowrap">From Previous Period</span>
                                                </div>
                                            </div>
                                            <div class="card-media">
                                                <i class="fa-solid fa-money-bill"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Ticket Sales -->
                                    <div class="col-xl-4 col-lg-6 col-md-6">
                                        <div class="dashboard-report-card success">
                                            <div class="card-content">
                                                <span class="card-title fs-6">Ticket Sales</span>
                                                <span class="card-sub-title fs-3">{{ $totalTicketsSold }}</span>
                                                <div class="d-flex align-items-center">
                                                    <span><i class="fa-solid fa-arrow-trend-up"></i></span>
                                                    <span class="text-Light font-12 ms-2 me-2">0.00%</span>
                                                    <span class="font-12 color-body text-nowrap">From Previous Period</span>
                                                </div>
                                            </div>
                                            <div class="card-media">
                                                <i class="fa-solid fa-ticket"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Page Views -->
                                    <div class="col-xl-4 col-lg-6 col-md-6">
                                        <div class="dashboard-report-card info">
                                            <div class="card-content">
                                                <span class="card-title fs-6">Page Views</span>
                                                <span class="card-sub-title fs-3">{{ $totalPageViews }}</span>
                                                <div class="d-flex align-items-center">
                                                    <span><i class="fa-solid fa-arrow-trend-up"></i></span>
                                                    <span class="text-Light font-12 ms-2 me-2">0.00%</span>
                                                    <span class="font-12 color-body text-nowrap">From Previous Period</span>
                                                </div>
                                            </div>
                                            <div class="card-media">
                                                <i class="fa-solid fa-eye"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Graph Section -->
                    <div class="main-card mt-4">
                        <div class="d-flex flex-wrap justify-content-between align-items-center border_bottom p-4">
                            <div class="dashboard-date-wrap d-flex flex-wrap justify-content-between align-items-center">
                                <div class="select-graphic-category">
                                    <div class="form-group main-form mb-2">
                                        <select class="selectpicker" data-width="150px">
                                            <option value="revenue">Revenue</option>
                                            <option value="ticketsales">Ticket Sales</option>
                                            <option value="pageviews">Page Views</option>
                                        </select>
                                    </div>
                                    <small class="mt-4">See the graphical representation below</small>
                                </div>
                            </div>
                            <div class="rs">
                                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                    <a href="{{ route('organiserdashboard', ['period' => 'monthly']) }}" class="btn btn-outline-primary {{ $period === 'monthly' ? 'active' : '' }}">Monthly</a>
                                    <a href="{{ route('organiserdashboard', ['period' => 'weekly']) }}" class="btn btn-outline-primary {{ $period === 'weekly' ? 'active' : '' }}">Weekly</a>
                                    <a href="{{ route('organiserdashboard', ['period' => 'daily']) }}" class="btn btn-outline-primary {{ $period === 'daily' ? 'active' : '' }}">Daily</a>
                                </div>
                            </div>
                        </div>
                        <div class="item-analytics-content p-4 ps-1 pb-2">
                            <canvas id="views-graphic"></canvas> <!-- Use canvas instead of div for Chart.js -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('views-graphic');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');

    const chartData = @json($chartData ?? []);

    if (!chartData.labels || chartData.labels.length === 0) {
        canvas.outerHTML = '<p class="text-center text-muted py-5">No revenue data available yet.</p>';
        return;
    }

    new Chart(ctx, {
        type: 'pie', // or 'doughnut' for ring style
        data: chartData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right', // or 'top', 'bottom'
                    labels: {
                        boxWidth: 20,
                        padding: 15
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            let value = context.raw || 0;
                            let total = context.dataset.data.reduce((a, b) => a + b, 0);
                            let percentage = ((value / total) * 100).toFixed(1);
                            return `${label}: $${value.toLocaleString()} (${percentage}%)`;
                        }
                    }
                },
                title: {
                    display: true,
                    text: 'Revenue Breakdown by Event',
                    font: { size: 16 }
                }
            },
            cutout: '30%', // for doughnut style (set to 0 for full pie)
        }
    });
});
</script>

@endsection
