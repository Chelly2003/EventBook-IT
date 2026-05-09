@extends('frontend.master')

@section('title', 'Checkout - ' . ($event->title ?? 'Event'))

@section('content')
<div class="container pt-5">

    {{-- Alerts --}}
    @if(session('error'))
        <div style="background:#ffdddd;color:#a10000;border:1px solid #ffaaaa;padding:15px;border-radius:8px;margin-bottom:20px;">
            ❌ {{ session('error') }}
        </div>
    @endif

    @if(session('info'))
        <div style="background:#ddffdd;color:#006600;border:1px solid #aaffaa;padding:15px;border-radius:8px;margin-bottom:20px;">
            ✔ {{ session('info') }}
        </div>
    @endif

    <div style="padding-top: 40px;"></div>

    <style>
        .main { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; padding: 40px; background: #fff; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .section { background: #f9f9f9; padding: 24px; border-radius: 10px; }
        .btn-green { background:#28a745; color:white; padding:16px; border:none; border-radius:8px; font-weight:bold; font-size:18px; cursor:pointer; width:100%; margin-top:20px; }
        .btn-green:hover { background:#218838; }
        @media (max-width: 768px) { .main { grid-template-columns: 1fr; } }
    </style>

    {{-- MAIN GRID --}}
    <div class="main" x-data="checkout()" x-init="init()">

        {{-- LEFT SIDE: Checkout Form --}}
        <div>
            <h2 class="text-2xl font-bold mb-6">Checkout</h2>

            <form :action="formAction" method="POST" @submit.prevent="submitForm">
                @csrf

                {{-- Name & Email --}}
                <div class="section mb-6">
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Full Name</label>
                        <input type="text" class="w-full px-4 py-3 border rounded-lg" value="{{ auth()->user()->name }}" readonly>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Email</label>
                        <input type="email" class="w-full px-4 py-3 border rounded-lg" value="{{ auth()->user()->email }}" readonly>
                    </div>
                </div>

                {{-- M-Pesa Phone --}}
                <div class="section mb-6" x-show="unitPrice > 0">
                    <label class="block text-sm font-medium mb-2">M-Pesa Phone Number</label>
                    <div class="relative">
                        <span class="absolute left-3 top-3 text-gray-600">+254</span>
                        <input type="tel" id="phone" name="phone" maxlength="9" placeholder="712345678" class="w-full pl-16 pr-4 py-3 border rounded-lg" x-model="phone">
                    </div>
                </div>

                {{-- Quantity --}}
                <div class="section mb-6">
                    <label class="block text-sm font-medium mb-2">Number of Tickets</label>
                    <input type="number" name="quantity" x-model="quantity" min="1" max="10" class="w-full px-4 py-3 border rounded-lg text-center text-lg font-semibold">
                </div>

                {{-- Heard From --}}
                <div class="section mb-6">
                    <label class="block text-sm font-medium mb-2">How did you hear about this event?</label>
                    <select name="heard_from" class="w-full px-4 py-3 border rounded-lg" x-model="heard_from">
                        <option value="">Select one</option>
                        <option value="Instagram">Instagram</option>
                        <option value="Facebook">Facebook</option>
                        <option value="TikTok">TikTok</option>
                        <option value="Friend">Friend</option>
                        <option value="Poster">Poster</option>
                        <option value="Website">Website</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                {{-- Total & Submit --}}
                <button type="submit" class="btn-green" x-text="unitPrice > 0 ? 'Pay with M-Pesa - KES ' + total.toFixed(2) : 'Confirm Booking'"></button>
            </form>

            {{-- Processing Modal --}}
            <div class="modal fade" id="processingModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="text-align:center; padding:30px;">
                        <h3 class="mb-3">Processing Payment...</h3>
                        <p>We have sent an M-PESA STK prompt to your phone.<br>Enter your PIN to continue.</p>
                        <div class="spinner-border text-success mt-3" role="status" style="width:40px;height:40px;"></div>
                    </div>
                </div>
            </div>

            {{-- Success Modal --}}
            <div class="modal fade" id="successModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="text-align:center; padding:30px;">
                        <h3 class="mb-3" x-text="unitPrice > 0 ? 'Payment Received 🎉' : 'Booking Confirmed 🎉'"></h3>
                        <p x-text="unitPrice > 0 ? 'Your payment has been confirmed. Preparing your ticket...' : 'Your booking is confirmed! Preparing your ticket...'"></p>
                        <div class="spinner-border text-primary mt-3" role="status" style="width:40px;height:40px;"></div>
                    </div>
                </div>
            </div>

        </div>

        {{-- RIGHT SIDE: Order Summary --}}
        <div>
            <h2 class="text-2xl font-bold mb-6">Order Summary</h2>
            <div class="border rounded-lg overflow-hidden">
                <div class="h-48 bg-gray-200">
                    @if($event->banner)
                        <img src="{{ asset('storage/' . $event->banner) }}" class="w-full h-full object-cover">
                    @endif
                </div>
                <div class="p-6">
                    <h3 class="font-bold">{{ $event->title }}</h3>
                    <p class="text-sm text-gray-600 mt-1">
                        {{ \Carbon\Carbon::parse($event->event_date ?? $event->date)->format('D, M d, Y') }}
                    </p>
                    <div class="mt-6 space-y-3">
                        <div class="flex justify-between">
                            <span>Tickets</span>
                            <span x-text="quantity"></span>
                        </div>
                        <div class="flex justify-between">
                            <span>Price per ticket</span>
                            <span>KES {{ number_format($event->price ?? 0, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold text-green-600 border-t pt-3">
                            <span>Total</span>
                            <span>KES <span x-text="total.toFixed(2)"></span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
function checkout() {
    return {
        phone: '',
        quantity: 1,
        unitPrice: {{ $event->price ?? 0 }},
        heard_from: '',
        get total() { return this.quantity * this.unitPrice; },
        get formAction() { return "{{ route('checkout.process', $event) }}"; },

        init() {
    let bookingId = null;

    // 1. From flash session (backup)
    @if(session('booking_id'))
        bookingId = {{ session('booking_id') }};
    @endif

    // 2. From URL query parameter (this is the main one now)
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('booking_id')) {
        bookingId = parseInt(urlParams.get('booking_id'));
    }

    if (bookingId) {
        console.log('✅ Polling started for booking ID:', bookingId);
        this.checkPaymentStatus(bookingId);
    } else {
        console.log('⚠️ Still no booking_id found. Polling will NOT start.');
    }
},
submitForm() {
    if (this.unitPrice <= 0) {
        // Submit the form normally for free events
        this.$el.submit();
        return;
    }

    if (!this.validatePhone()) return;

    // Show processing modal
    let pModal = new bootstrap.Modal(document.getElementById('processingModal'), {
        backdrop: 'static',
        keyboard: false
    });
    pModal.show();

    this.$el.submit();
},

        validatePhone() {
            if (!this.phone || !/^\d{9}$/.test(this.phone)) {
                alert('Please enter a valid 9-digit M-Pesa number (e.g. 712345678)');
                return false;
            }
            return true;
        },

        checkPaymentStatus(bookingId) {
            console.log('🔄 Polling loop active for booking:', bookingId);

            const interval = setInterval(() => {
                fetch(`/booking/status/${bookingId}`)
                    .then(res => res.json())
                    .then(data => {
                        console.log('Current status:', data.status);

                        if (data.status === 'PAID') {
                            clearInterval(interval);
                            console.log('🎉 Payment successful! Redirecting to confirmed page...');

                            // Hide processing modal
                            let pModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('processingModal'));
                            if (pModal) pModal.hide();

                            // Show success modal briefly
                            let sModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('successModal'));
                            sModal.show();

                            // Redirect to booking confirmed page
                            setTimeout(() => {
                                window.location.href = `/booking/confirmed/${bookingId}`;
                            }, 2000);

                        } else if (data.status === 'FAILED') {
                            clearInterval(interval);
                            let pModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('processingModal'));
                            if (pModal) pModal.hide();
                            alert('Payment failed. Please try again.');
                        }
                    })
                    .catch(err => {
                        console.error('Polling error:', err);
                    });
            }, 4000); // every 4 seconds
        }
    }
}
</script>

@endsection
