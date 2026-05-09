@extends('frontend.master')

@section('title', 'Invoice')

@section('content')

<section class="invoice-hero text-center text-white py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <h1>Your Invoice & Ticket</h1>
        <p>Thank you for your purchase! Here is your official ticket.</p>
    </div>
</section>

<div class="container my-5">
    <div class="card p-4 shadow">

        <!-- Header -->
        <div class="text-center mb-4">
            <h3>Invoice #INV-{{ $booking->event->id }}-{{ now()->format('Ymd') }}</h3>
            <p>Issued on: {{ now()->format('F d, Y') }}</p>
        </div>

        <div class="row">
            <!-- Event Info -->
            <div class="col-md-6">
                <h5>Event Details</h5>

                <p><strong>Event:</strong> {{ $booking->event->title }}</p>

                <p><strong>Date & Time:</strong>
                    {{ \Carbon\Carbon::parse($booking->event->date)->format('D, M d, Y • g:i A') }}
                </p>

                <p><strong>Duration:</strong> {{ $booking->event->duration }} hours</p>

                <p><strong>Attendee:</strong> {{ auth()->user()->name }}</p>
                <p><strong>Email:</strong> {{ auth()->user()->email }}</p>

                @foreach($booking->items as $item)
                    <p><strong>Ticket:</strong> {{ $item->ticket_type }} × {{ $item->quantity }}</p>
                @endforeach
            </div>

            <!-- Payment Info -->
            <div class="col-md-6">
                <h5>Payment Summary</h5>

                <p><strong>Total:</strong>
                    <span class="text-success fs-4">
                        KES {{ number_format($booking->total_amount, 2) }}
                    </span>
                </p>

                <p><strong>Payment Method:</strong>
                    {{ ucfirst($booking->payment_method) }}
                </p>

                <p><strong>Status:</strong>
                    <span class="badge bg-success">Paid</span>
                </p>

                <p><strong>Transaction ID:</strong> MPESA-{{ now()->format('ymdHis') }}</p>
            </div>
        </div>

        <!-- Ticket Code -->
        <div class="text-center my-4">
            <h4 class="text-success">{{ $booking->booking_code }}</h4>
        </div>

        <!-- QR Code -->
               <!-- QR Code -->
        <div class="text-center my-4">
            <h5 class="mb-3 text-success">Scan this QR Code for Ticket Verification</h5>
            <div id="qrcode"
                 style="margin: 0 auto;
                        width: 260px;
                        height: 260px;
                        padding: 20px;
                        background: white;
                        border: 15px solid #fff;
                        box-shadow: 0 5px 25px rgba(0,0,0,0.2);">
            </div>
            <small class="text-muted d-block mt-2">Your unique booking code is embedded</small>
        </div>

        <!-- Barcode -->
        <div class="text-center my-3">
            <svg id="barcode"></svg>
        </div>

        <!-- Buttons -->
        <div class="text-center mt-4">
            <button onclick="window.print()" class="btn btn-success me-2">
                🖨️ Print Ticket
            </button>

            <button onclick="downloadAsPDF()" class="btn btn-primary me-2">
                📥 Download as PDF
            </button>

            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                Back
            </a>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const ticketCode = "{{ $booking->booking_code ?? 'NO-CODE' }}";

    if (!ticketCode || ticketCode === 'NO-CODE') {
        console.error("No booking code found!");
        document.getElementById("qrcode").innerHTML = "<p style='color:red; text-align:center;'>Error: No booking code</p>";
        return;
    }

    console.log("✅ Generating QR for:", ticketCode);

    // Clear previous content
    document.getElementById("qrcode").innerHTML = "";

    // Generate QR Code
    new QRCode(document.getElementById("qrcode"), {
        text: ticketCode,
        width: 220,
        height: 220,
        colorDark: "#000000",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.M
    });

    // Generate Barcode
    JsBarcode("#barcode", ticketCode, {
        format: "CODE128",
        width: 2,
        height: 80,
        displayValue: true,
        fontSize: 14,
        textAlign: "center"
    });
});

// Download as PDF Function
function downloadAsPDF() {
    const element = document.querySelector('.card');   // This targets the main ticket card

    const opt = {
        margin:       0.5,
        filename:     'Ticket-INV-{{ $booking->event->id ?? "unknown" }}.pdf',
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { scale: 2, useCORS: true },
        jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
    };

    html2pdf().set(opt).from(element).save();
}
</script>


@endsection
