
@extends('frontend.master')

@section('title', 'Event Detail & Preview')
 @section('content')

<style>
/* ---------------- PAGE SCOPE ---------------- */
.event-page {
    font-family: 'Inter', sans-serif;
}

/* ---------------- HERO SECTION ---------------- */
.event-page .relative img {
    transition: transform 0.5s ease;
}
.event-page .relative img:hover {
    transform: scale(1.05);
}
.event-page .relative .absolute h1 {
    text-shadow: 2px 2px 8px rgba(0,0,0,0.7);
}
.event-page .relative .absolute p {
    text-shadow: 1px 1px 5px rgba(0,0,0,0.5);
}

/* ---------------- LEFT COLUMN ---------------- */
.event-page .md\:col-span-2 h3 {
    font-weight: 600;
    margin-bottom: 0.25rem;
}
.event-page .md\:col-span-2 .text-gray-700 {
    line-height: 1.8;
}

/* ---------------- RIGHT COLUMN / TICKET BOX ---------------- */
.event-page .md\:col-span-1 {
    transition: all 0.3s ease;
}
.event-page .md\:col-span-1:hover {
    transform: translateY(-2px);
}
.event-page .ticket-box button {
    transition: all 0.3s ease;
}
.event-page .ticket-box button:hover {
    transform: scale(1.02);
}
.event-page .bg-white.rounded-2xl.shadow-xl {
    border: 1px solid #e5e7eb; /* subtle border */
}

/* ---------------- AVAILABILITY BADGES ---------------- */
.event-page .bg-red-100,
.event-page .bg-orange-100,
.event-page .bg-green-100 {
    font-size: 0.95rem;
}
.event-page .bg-red-100 {
    background-color: #fee2e2;
    border-color: #fca5a5;
}
.event-page .bg-orange-100 {
    background-color: #ffedd5;
    border-color: #fdba74;
}
.event-page .bg-green-100 {
    background-color: #dcfce7;
    border-color: #86efac;
}

/* ---------------- BUTTONS ---------------- */
.event-page .button {
    font-weight: 600;
    cursor: pointer;
}
.event-page .button:disabled {
    cursor: not-allowed;
    opacity: 0.65;
}

/* ---------------- RESPONSIVE ---------------- */
@media (max-width: 768px) {
    .event-page .relative h1 {
        font-size: 2.5rem;
    }
    .event-page .md\:col-span-1 {
        position: static !important;
        margin-top: 2rem;
    }
}

/* ---------------- SMALL ANIMATIONS ---------------- */
.event-page .fade-in {
    animation: fadeIn 0.6s ease forwards;
    opacity: 0;
}
@keyframes fadeIn {
    to { opacity: 1; }
}
</style>




<!-- Hero Section -->
<div class="relative">
    @if($event && $event->banner)


        <img src="{{ asset('storage/' . $event->banner) }}" class="w-full h-96 object-cover">
    @else
        <div class="w-full h-96 bg-gray-300 flex items-center justify-center text-gray-600">No banner available</div>
    @endif

    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>

    <div class="absolute bottom-10 left-8 text-white max-w-3xl">
        <h1 class="text-5xl font-bold">{{ $event->title ?? 'Event Title' }}</h1>
        <p class="text-xl mt-2 opacity-90">{{ $event?->organiser?->name ?? 'Organizer' }}</p>
    </div>
</div>


<div class="max-w-7xl mx-auto px-4 py-12 grid md:grid-cols-3 gap-10">

    <!-- LEFT COLUMN -->
    <div class="md:col-span-2 space-y-10">

        <!-- DATE & TIME -->
        <div class="flex gap-5">
            <div class="bg-green-100 p-4 rounded-full">
                <i class="far fa-calendar-alt text-green-600 text-2xl"></i>
            </div>
            <div>
                <h3 class="font-bold text-gray-800">Date and Time</h3>
                <p class="text-xl mt-1">
                    {{ $event?->event_date?->format('l, d F Y') }} at {{ $event?->event_time?->format('H:i') }}
                </p>
            </div>
        </div>

        <!-- LOCATION -->
        <div class="flex gap-5">
            <div class="bg-green-100 p-4 rounded-full">
                <i class="fas fa-map-marker-alt text-green-600 text-2xl"></i>
            </div>
            <div>
                <h3 class="font-bold text-gray-800">Location</h3>
                <p class="text-xl mt-1">
                    {{ $event->venue_name }}<br>
                    {{ $event->address_line1 }} {{ $event->city }}, {{ $event->country }}
                </p>
            </div>
        </div>

         <!-- CATEGORY -->
        <div class="flex gap-5">
            <div class="bg-green-100 p-4 rounded-full">
                <i class="fas fa-map-marker-alt text-green-600 text-2xl"></i>
            </div>
            <div>
                <h3 class="font-bold text-gray-800">Category</h3>
                <p class="text-xl mt-1">
                    {{ $event->event_category }}<br>

                </p>
            </div>
        </div>

        <!-- DESCRIPTION -->
        <div>
            <h2 class="text-3xl font-bold mb-6">About This Event</h2>
            <div class="text-gray-700 leading-relaxed text-lg">
                {!! nl2br(e($event->description)) !!}
            </div>
        </div>
    </div>

   <!-- RIGHT COLUMN (TICKETS + BOOKING BOX) -->
<div class="md:col-span-1">
    <div class="bg-white rounded-2xl shadow-xl p-8 sticky top-6">

        <h3 class="text-2xl font-bold mb-6">Tickets</h3>

        <!-- IMPROVED TICKET STATUS + COUNT -->
        @if($event && $event->capacity)
            <div class="mb-6 space-y-3">

                <!-- Availability Badge -->
                @if($status === 'sold_out')
                    <div class="bg-red-100 border border-red-300 text-red-700 p-4 rounded-lg text-center font-bold">
                        ❌ Sold Out (0 tickets remaining)
                    </div>
                @elseif($status === 'low')
                    <div class="bg-orange-100 border border-orange-300 text-orange-700 p-4 rounded-lg text-center font-bold">
                        ⚠️ Only {{ $ticketsLeft }} Tickets left! Hurry up!
                    </div>
                @else
                    <div class="bg-green-100 border border-green-300 text-green-700 p-4 rounded-lg text-center font-bold">
                        ✔ Available — {{ $ticketsLeft }} tickets left
                    </div>
                @endif

                <!-- Capacity Info (nice to show) -->
                <p class="text-center text-gray-600 text-sm">
                    Capacity: {{ $event->capacity }} tickets
                </p>
            </div>
        @else
            <div class="bg-gray-100 border border-gray-200 text-gray-700 p-4 rounded-lg mb-6 text-center">
                Capacity information not available
            </div>
        @endif

        <!-- TICKET PRICE DISPLAY -->
        <div class="text-center mb-8">
            <p class="text-gray-500">Ticket Price</p>
            <p class="text-4xl font-extrabold text-green-700">
                @if($event->price > 0)
                    KES {{ number_format($event->price, 0) }}
                @else
                    Free
                @endif
            </p>
        </div>

        <!-- BOOK BUTTON LOGIC -->
        <div class="mt-8 pt-6 border-t">
            @if(!$event)
                <button disabled class="w-full bg-gray-400 text-white py-4 rounded-xl text-xl font-bold opacity-75">
                    Event Not Available
                </button>

            @elseif($status === 'sold_out')
                <button disabled class="w-full bg-gray-400 text-white py-4 rounded-xl text-xl font-bold opacity-75">
                    Sold Out
                </button>

            @elseif(!auth()->check())
                <a href="{{ route('login') }}" class="block">
                    <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-xl text-xl font-bold transition">
                        Login to Book
                    </button>
                </a>

            @else
                <!-- USER LOGGED IN + TICKETS AVAILABLE -->
                <form action="{{ route('ticket.generate') }}" method="POST">
                    @csrf
                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                    <input type="hidden" name="price" value="{{ $event->price ?? 0 }}">

                 <a href="{{ route('checkout.show', $event->id) }}"
 class="w-full bg-green-600 hover:bg-green-700 text-white py-4 rounded-xl text-xl font-bold transition text-center inline-block">
    Book Ticket Now
</a>

                </form>
            @endif
        </div>

    </div>
</div>

<script>
// Optional: Smooth scroll to ticket section when button clicked
document.addEventListener("DOMContentLoaded", function() {
    const bookBtn = document.querySelector("form button");
    if(bookBtn) {
        bookBtn.addEventListener("click", function() {
            const ticketSection = document.querySelector(".md\\:col-span-1");
            if(ticketSection) {
                ticketSection.scrollIntoView({ behavior: "smooth", block: "start" });
            }
        });
    }
});
</script>

@endsection
