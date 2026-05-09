@extends('frontend.master')

@section('title', 'Booking Confirmed')

<?php $hideFooter = true; ?>
@section('content')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmed - Barren</title>
    <style>

        .wrapper {
            max-width: 600px;
            margin: 0px auto;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }
        .header1 {
            background: #fff;
            padding: 20px 30px;
            border-bottom: 1px solid #eee;
            text-align: center;
            font-size: 28px;
            font-weight: bold;
            color: #28a745;
        }
        .content {
            padding: 50px 40px;
            text-align: center;
        }
        .success-icon {
            width: 90px;
            height: 90px;
            background: #d4edda;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            font-size: 48px;
            color: #28a745;
        }
        .h1 {
            font-size: 28px;
            margin: 0 0 15px;
            color: #333;
        }
       .p {
            font-size: 12px;
            color: #666;
            line-height: 1.6;
            margin-bottom: 40px;
        }
        .ticket-box {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 30px;
            margin: 0 auto 40px;
            max-width: 480px;
            text-align: left;
            overflow: hidden;
        }
        .event-img {
            width: 90px;
            height: 90px;
            background: #ddd;
            float: left;
            margin-right: 20px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            color: #999;
        }
        .event-details {
            overflow: hidden;
        }
        .event-title {
            font-size: 14px;
            font-weight: bold;
            margin: 0 0 8px;
        }
        .event-meta {
            color: #666;
            font-size: 12px;
            margin: 4px 0;
        }
        .ticket-info {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 15px;
        }
        .total {
            font-size: 22px;
            font-weight: bold;
            color: #28a745;
        }
        .view-btn {
            background: #28a745;
            color: white;
            border: none;
            padding: 16px 40px;
            font-size: 17px;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: background 0.3s;
        }
        .view-btn:hover {
            background: #218838;
        }
        .ticket-icon {
            font-size: 20px;
        }

    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<br><br>

<div class="wrapper">
    <div class="header1">Event-Book IT</div>

    <div class="content">
        <div class="success-icon">Checkmark</div>
        <h1>Booking Confirmed</h1>
        <p>We are pleased to inform you that your reservation request has<br>been received and confirmed.</p>

        <div class="ticket-box">
            <div class="event-img">
    <img src="{{ asset('storage/' . $booking->event->banner) }}"
         alt="Event Image"
         style="width:90px; height:90px; border-radius:6px; object-fit:cover;">
</div>

            <div class="event-details">
                <div class="event-title">{{ $booking->event->title }}</div>
                <div class="event-meta">
    {{ \Carbon\Carbon::parse($booking->event->date)->format('D, M d, Y g:i A') }}
</div>
               <div class="event-meta">Duration: {{ $booking->event->duration }} hours</div>

               <div class="event-meta">Hosted by: {{ $booking->event->organizer ?? 'Event Organizer' }}</div>


                <div class="ticket-info">
                    <div>Ticket × 1</div>
<div class="total">Total: KES {{ number_format($booking->event->price, 2) }}</div>

                </div>
            </div>
        </div>

        <!-- This button goes to your invoice/ticket page -->
        <button class="view-btn" onclick="window.location.href='{{ route('invoice', $booking->id) }}'">
            <span class="ticket-icon"></span>
            View Ticket
        </button>
         <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                           <button onclick="window.history.back()" class="btn btn-secondary">
    ← Back
</button>
                        </a>

    </div>
</div>
<br>
@endsection
