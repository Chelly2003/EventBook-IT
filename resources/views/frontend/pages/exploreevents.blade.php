@extends('frontend.master')

@section('title', 'Explore Events')

@section('content')

<style>
.hero-banner {
      background-image: url('{{ asset("assets/images/event-imgs/eventherobanner.avif") }}');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    position: relative;
    padding: 130px 0;
    color: #fff;
}
.hero-banner::after {
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.5);

}
.hero-banner .hero-banner-content {
    position: relative;
    z-index: 2;
    text-align: center;
}
</style>

<div class="wrapper">

    {{-- Hero Banner --}}
    <div class="hero-banner">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-9 col-md-10">
                    <div class="hero-banner-content">
                        <h2>{{ $heroTitle ?? 'Discover Events For All The Things You Love' }}</h2>
                        <br><br>

                        {{-- Search Form --}}
                     {{-- Search Form --}}
<form action="{{ route('exploreevents') }}" method="GET" class="main-form">
    <div class="row g-3 justify-content-center">

        {{-- Event Type --}}
        <div class="col-lg-5 col-md-12">
            <select name="event_type" class="form-select form-select-lg" style="height: 55px;">
                <option value="" {{ request('event_type') == '' ? 'selected' : '' }}>Browse All Events</option>
                @foreach($eventTypes as $type)
                    <option value="{{ $type }}" {{ request('event_type') == $type ? 'selected' : '' }}>
                        {{ ucfirst($type) }} Events
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Category --}}
        <div class="col-lg-5 col-md-12">
            <select name="category" class="form-select form-select-lg" style="height: 55px;">
                <option value="" {{ request('category') == '' ? 'selected' : '' }}>All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_', ' ', $cat)) }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Find Button --}}
        <div class="col-lg-2 col-md-12">
            <button type="submit" class="main-btn btn-hover w-100" style="height: 55px;">Find</button>
        </div>

    </div>
</form>


                    </div>
                </div>
            </div>
        </div>
    </div>
<br>
    {{-- Explore Events Section --}}
    <div class="explore-events p-70">
        <div class="container">

            <div class="row">
                <div class="col-12">
                    <div class="main-title">
                        <h3>Explore Events</h3>
                    </div>
                </div>
            </div>

            {{-- Category Filters --}}
            <div class="row mt-4">
                <div class="col-12">
                    <div class="event-filter-items">
                        <div class="featured-controls">

                            {{-- Date Filters --}}
                            <div class="filter-tag mb-2">
                                @foreach($dateFilters as $key => $label)
                                    <a href="{{ route('exploreevents', array_merge(request()->query(), ['date' => $key])) }}"
                                       class="{{ request('date') === $key ? 'active' : '' }}">
                                       {{ $label }}
                                    </a>
                                @endforeach
                            </div>

                            {{-- Category Filters --}}
                            <div class="controls">
                                @foreach($categories as $cat)
                                    <a href="{{ route('exploreevents', array_merge(request()->query(), ['category' => $cat])) }}"
                                       class="control {{ request('category') === $cat ? 'active' : '' }}">
                                        {{ ucfirst(str_replace('_', ' ', $cat)) }}
                                    </a>
                                @endforeach
                            </div>

                        </div>

                        {{-- Events --}}
                        <div class="row" data-ref="event-filter-content">
                            @forelse($events as $event)
                                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mix {{ $event->category ?? '' }}" data-ref="mixitup-target">
                                    <div class="main-card mt-4">
                                        <div class="event-thumbnail">
                                            <a href="{{ route('venue.event.show', $event->id) }}" class="thumbnail-img">
                                                <img src="{{ asset('storage/' . $event->banner) }}" alt="{{ $event->title }}">
                                            </a>
                                            <span class="bookmark-icon" title="Bookmark"></span>
                                        </div>

                                        <div class="event-content">
                                            <a href="{{ route('venue.event.show', $event->id) }}" class="event-title">{{ $event->title }}</a>

                                            <p class="mt-1" style="font-size: 13px; color:#777;">
                                                <strong>Type:</strong> {{ ucfirst($event->event_type) }}
                                            </p>

                                            @if($event->event_type === 'online')
                                                <p class="mt-1" style="font-size: 13px; color:#777;">
                                                    <strong>Platform:</strong> {{ $event->online_platform }}
                                                </p>
                                            @elseif($event->event_type === 'venue')
                                                <p class="mt-1" style="font-size: 13px; color:#777;">
                                                    <strong>Venue:</strong> {{ $event->venue_name }}
                                                </p>
                                                <p class="mt-1" style="font-size: 13px; color:#777;">
                                                    <strong>Location:</strong> {{ $event->address_line1 }}, {{ $event->city }}, {{ $event->county }}
                                                </p>
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

                        {{-- See More --}}
                        <div class="browse-btn mt-4 text-center">
                            <a href="#" class="main-btn btn-hover">See More</a>
                        </div>
<br>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

@endsection
