

@extends('frontend.master')

@section('title', 'Home')

@section('content')

<style>
    .hero-banner {
    background-image: url('{{ asset("assets/images/event-imgs/eventherobanner.avif") }}');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    position: relative;
    padding: 130px 0; /* adjust height */
    color: #fff;
}
.hero-banner::after {
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.5); /* dark overlay for text readability */
}
.hero-banner .hero-banner-content {
    position: relative;
    z-index: 2;
    text-align: center;
}
    </style>
<div class="wrapper">
		<div class="hero-banner">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-xl-7 col-lg-9 col-md-10">
						<div class="hero-banner-content">
							<h2>The Easiest and Most Powerful Online Event Booking and Ticketing System</h2>
							<br><br>
						<!--	<a href="{{ route('createevent') }}" class="main-btn btn-hover">Create Event <i class="fa-solid fa-arrow-right ms-3"></i></a>-->
						</div>
					</div>
				</div>
			</div>
		</div>
        <br>
		<div class="explore-events p-65">
			<div class="container">
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12">
						<div class="main-title">
							<h3>Explore Events</h3>
						</div>
					</div>
					<div class="col-xl-12 col-lg-12 col-md-12">
						<div class="event-filter-items">
							<div class="featured-controls">

    <!-- Date filters -->
    <div class="filter-tag">
        <a href="{{ route('home') }}"
           class="{{ $dateFilter === 'all' ? 'active' : '' }}">All</a>

        <a href="{{ route('home', ['date' => 'today']) }}"
           class="{{ $dateFilter === 'today' ? 'active' : '' }}">Today</a>

        <a href="{{ route('home', ['date' => 'tomorrow']) }}"
           class="{{ $dateFilter === 'tomorrow' ? 'active' : '' }}">Tomorrow</a>

        <a href="{{ route('home', ['date' => 'this_week']) }}"
           class="{{ $dateFilter === 'this_week' ? 'active' : '' }}">This Week</a>

        <a href="{{ route('home', ['date' => 'this_weekend']) }}"
           class="{{ $dateFilter === 'this_weekend' ? 'active' : '' }}">This Weekend</a>

        <a href="{{ route('home', ['date' => 'next_week']) }}"
           class="{{ $dateFilter === 'next_week' ? 'active' : '' }}">Next Week</a>

        <!-- Add more dates if needed -->
    </div>

    <!-- Category filters -->
    <div class="controls">
        <a href="{{ route('home') }}"
           class="control {{ $categoryFilter === 'all' ? 'active' : '' }}">All</a>

        <a href="{{ route('home', ['category' => 'arts']) }}"
           class="control {{ $categoryFilter === 'arts' ? 'active' : '' }}">Arts</a>

        <a href="{{ route('home', ['category' => 'business']) }}"
           class="control {{ $categoryFilter === 'business' ? 'active' : '' }}">Business</a>

        <a href="{{ route('home', ['category' => 'concert']) }}"
           class="control {{ $categoryFilter === 'concert' ? 'active' : '' }}">Concert</a>

        <a href="{{ route('home', ['category' => 'workshops']) }}"
           class="control {{ $categoryFilter === 'workshops' ? 'active' : '' }}">Workshops</a>

        <a href="{{ route('home', ['category' => 'coaching']) }}"
           class="control {{ $categoryFilter === 'coaching' ? 'active' : '' }}">Coaching and Consulting</a>

        <a href="{{ route('home', ['category' => 'health']) }}"
           class="control {{ $categoryFilter === 'health' ? 'active' : '' }}">Health and Wellbeing</a>

        <a href="{{ route('home', ['category' => 'volunteer']) }}"
           class="control {{ $categoryFilter === 'volunteer' ? 'active' : '' }}">Volunteer</a>

        <a href="{{ route('home', ['category' => 'sports']) }}"
           class="control {{ $categoryFilter === 'sports' ? 'active' : '' }}">Sports</a>

        <a href="{{ route('home', ['free' => 'true']) }}"
           class="control {{ request()->query('free') === 'true' ? 'active' : '' }}">Free</a>
    </div>
</div>

												<div class="row" data-ref="event-filter-content">
    @forelse($events as $event)
    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mix " data-ref="mixitup-target">
        <div class="main-card mt-4">
            <div class="event-thumbnail">
                <a href="{{ route('venue.event.show', $event->id) }}" class="thumbnail-img">
                    <img src="{{ asset('storage/' . $event->banner) }}" alt="{{ $event->title }}">
                </a>
                <span class="bookmark-icon" title="Bookmark"></span>
            </div>

            <div class="event-content">
    <a href="{{ route('venue.event.show', $event->id) }}" class="event-title">{{ $event->title }}</a>

    {{-- Event Type --}}
    <p class="mt-1" style="font-size: 13px; color:#777;">
        <strong>Type:</strong> {{ ucfirst($event->event_type) }}
    </p>

    {{-- ONLINE EVENT DETAILS (ONLY SHOW PLATFORM) --}}
    @if($event->event_type === 'online')
        <p class="mt-1" style="font-size: 13px; color:#777;">
            <strong>Platform:</strong> {{ $event->online_platform }}
        </p>
    @endif

    {{-- VENUE EVENT DETAILS --}}
    @if($event->event_type === 'venue')
        <p class="mt-1" style="font-size: 13px; color:#777;">
            <strong>Venue:</strong> {{ $event->venue_name }}
        </p>
        <p class="mt-1" style="font-size: 13px; color:#777;">
            <strong>Location:</strong>
            {{ $event->address_line1 }},
            {{ $event->city }},
            {{ $event->county }}
        </p>

        @if($event->google_maps_url)

        @endif
    @endif

    <div class="duration-price-remaining mt-2">
        <span class="duration-price">{{ $event->price ? 'KES ' . $event->price : 'Free*' }}</span>
        <span class="remaining">
            @if($event->tickets_remaining)
                <i class="fa-solid fa-ticket fa-rotate-90"></i> {{ $event->tickets_remaining }} Remaining
            @endif
        </span>
    </div>
</div>

            <div class="event-footer">
                <div class="event-timing">
                    <div class="publish-date">
                        <span><i class="fa-solid fa-calendar-day me-2"></i>{{ $event->event_date->format('d M') }}</span>
                        <span class="dot"><i class="fa-solid fa-circle"></i></span>
                        <span>{{ $event->event_date->format('D, g:i A') }}</span>
                    </div>
                    <span class="publish-time"><i class="fa-solid fa-clock me-2"></i>{{ $event->duration ?? '1h' }}</span>
                </div>
            </div>
        </div>
    </div>
    @empty
    <p>No events available at the moment.</p>
    @endforelse
</div>

									<div class="sponsor">
										<a href="#"><img src="images/icons/sponsor-4.html" alt=""></a>
									</div>
								</div>
								<div class="item">
									<div class="sponsor">
										<a href="#"><img src="images/icons/sponsor-5.html" alt=""></a>
									</div>
								</div>
								<div class="item">
									<div class="sponsor">
										<a href="#"><img src="images/icons/sponsor-6.html" alt=""></a>
									</div>
								</div>
								<div class="item">
									<div class="sponsor">
										<a href="#"><img src="images/icons/sponsor-7.html" alt=""></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection
