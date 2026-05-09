

@extends('frontend.master')

@section('title', 'Explore Events')

@section('content')
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=9">
    <meta name="description" content="Gambolthemes">
    <meta name="author" content="Gambolthemes">
    <title>Barren - Calculate Your Ticket Costs</title>

    <!-- Favicon Icon -->
    <link rel="icon" type="image/png" href="images/fav.png">

    <!-- Stylesheets -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link href='vendor/unicons-2.0.1/css/unicons.css' rel='stylesheet'>
    <link href="css/style.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">
    <link href="css/night-mode.css" rel="stylesheet">

    <!-- Vendor Stylesheets -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="vendor/OwlCarousel/assets/owl.carousel.css" rel="stylesheet">
    <link href="vendor/OwlCarousel/assets/owl.theme.default.min.css" rel="stylesheet">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">

    <style>
        /* Custom styles for fee calculator to match Barren theme and screenshot */
        .fee-hero { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 80px 0; text-align: center; }
        .fee-hero h1 { font-size: 2.5rem; margin-bottom: 1rem; }
        .fee-hero p { font-size: 1.1rem; margin-bottom: 2rem; }
        .calculator-section { padding: 60px 0; }
        .calculator-panel { background: #f8f9fa; border-radius: 10px; padding: 30px; margin-bottom: 30px; }
        .input-group-custom { margin-bottom: 20px; }
        .input-group-custom label { font-weight: 500; display: block; margin-bottom: 5px; }
        .input-group-custom select, .input-group-custom input { width: 100%; padding: 10px; border: 1px solid #dee2e6; border-radius: 5px; }
        .btn-toggle { background: white; border: 2px solid #dee2e6; padding: 10px 20px; border-radius: 5px; margin: 0 5px; cursor: pointer; }
        .btn-toggle.active { background: #007bff; color: white; border-color: #007bff; }
        .breakdown-panel { background: white; border-radius: 10px; padding: 30px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .breakdown-item { display: flex; justify-content: space-between; margin-bottom: 10px; padding: 10px 0; border-bottom: 1px solid #eee; }
        .breakdown-item:last-child { border-bottom: none; font-weight: bold; font-size: 1.2rem; color: #28a745; }
        .faq-section { padding: 60px 0; background: #f8f9fa; }
        .faq-item { margin-bottom: 15px; }
        .faq-item .accordion-button { background: white; border-radius: 5px; }
    </style>
</head>
 <div class="wrapper">
        <!-- Fee Calculator Hero Section -->
        <section class="fee-hero">
            <div class="container">
                <h1>Understand Your Ticket Costs</h1>
                <p>Calculate what you'll pay for events on Barren. Fees vary by event type and organizer choices—transparency first!</p>
                <a href="#calculator" class="btn btn-light btn-lg">Start Calculating</a>
            </div>
        </section>

        <!-- Calculator Section -->
        <section id="calculator" class="calculator-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="calculator-panel">
                            <h3 class="mb-4">Event Details</h3>
                            <div class="input-group-custom">
                                <label>Is the event free or paid?</label>
                                <div>

                                    <button type="button" class="btn-toggle active" data-type="free">Free</button>
                                    <button type="button" class="btn-toggle" data-type="paid">Paid</button>
                                </div>
                            </div>
                            <div class="input-group-custom" id="ticket-price-group" style="display: none;">
                                <label>Ticket Price (USD)</label>
                                <input type="number" id="ticketPrice" placeholder="0.00" step="0.01" value="0.00">
                            </div>
                            <div class="input-group-custom">
                                <label>How many tickets?</label>
                                <input type="number" id="ticketQty" placeholder="0" value="0" min="0">
                            </div>
                            <div class="input-group-custom" id="payment-group" style="display: none;">
                                <label>How are fees handled? (Organizer's choice)</label>
                                <div>
                                    <button type="button" class="btn-toggle active" data-handling="pass">Passed to You</button>
                                    <button type="button" class="btn-toggle" data-handling="absorb">Absorbed by Organizer</button>
                                </div>
                            </div>
                            <!--number-->
<div class="input-group-custom" id="phone-group" style="display: none;">
    <label>Your Phone Number (e.g., +254712345678)</label>
    <input type="tel" id="phoneNumber" placeholder="+254712345678" pattern="\+[0-9]{12}">
</div>
                            <button class="btn btn-primary mt-3" onclick="simulatePurchase()">Simulate Purchase</button>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="breakdown-panel">
                            <h3 class="mb-4">Your Cost Breakdown</h3>
                            <div class="breakdown-item">
                                <span>Base Ticket Total</span>
                                <span id="baseTotal">USD 0.00</span>
                            </div>
                            <div class="breakdown-item">
                                <span>Service Fee (5% for paid events)</span>
                                <span id="serviceFee">USD 0.00</span>
                            </div>
                            <div class="breakdown-item">
                                <span>Processing Fee (2.9% + $0.30)</span>
                                <span id="processingFee">USD 0.00</span>
                            </div>
                            <div class="breakdown-item">
                                <span>Total You'll Pay</span>
                                <span id="totalPay">USD 0.00</span>
                            </div>
                            <small class="text-muted">Per Ticket: <span id="perTicket">USD 0.00</span> (Exclusive of taxes)</small>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section class="faq-section">
            <div class="container">
                <h2 class="text-center mb-4">Frequently Asked Questions</h2>
                <div class="accordion" id="faqAccordion">
                    <div class="faq-item">
                        <h2 class="accordion-header" id="faq1">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">
                                Are there fees for free events?
                            </button>
                        </h2>
                        <div id="collapse1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                No—free events have zero fees for buyers. You'll only pay if the organizer adds optional donations.
                            </div>
                        </div>
                    </div>
                    <div class="faq-item">
                        <h2 class="accordion-header" id="faq2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">
                                How do passed-on vs absorbed fees work?
                            </button>
                        </h2>
                        <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Organizers choose: "Passed on" adds fees to your total; "Absorbed" means they cover it, so you pay only the base price.
                            </div>
                        </div>
                    </div>
                    <div class="faq-item">
                        <h2 class="accordion-header" id="faq3">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
                                What payment methods are accepted?
                            </button>
                        </h2>
                        <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Credit/debit cards, PayPal, and Apple Pay. All secure and fee-inclusive where applicable.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- Body End -->

    <!-- Footer Start -->
    <footer class="footer mt-auto">
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-content">
                            <h4>Company</h4>
                            <ul class="footer-link-list">
                                <li><a href="about_us.html" class="footer-link">About Us</a></li>
                                <li><a href="help_center.html" class="footer-link">Help Center</a></li>
                                <li><a href="faq.html" class="footer-link">FAQ</a></li>
                                <li><a href="contact_us.html" class="footer-link">Contact Us</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-content">
                            <h4>Useful Links</h4>
                            <ul class="footer-link-list">
                                <li><a href="explore_events.html" class="footer-link">Explore Events</a></li>
                                <li><a href="privacy_policy.html" class="footer-link">Privacy Policy</a></li>
                                <li><a href="term_and_conditions.html" class="footer-link">Terms & Conditions</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-content">
                            <h4>Resources</h4>
                            <ul class="footer-link-list">
                                <li><a href="pricing.html" class="footer-link">Pricing</a></li>
                                <li><a href="our_blog.html" class="footer-link">Blog</a></li>
                                <li><a href="refer_a_friend.html" class="footer-link">Refer a Friend</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-content">
                            <h4>Follow Us</h4>
                            <ul class="social-links">
                                <li><a href="#" class="social-link"><i class="fab fa-facebook-square"></i></a></li>
                                <li><a href="#" class="social-link"><i class="fab fa-instagram"></i></a></li>
                                <li><a href="#" class="social-link"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a></li>
                                <li><a href="#" class="social-link"><i class="fab fa-youtube"></i></a></li>
                            </ul>
                        </div>
                        <div class="footer-content">
                            <h4>Download Mobile App</h4>
                            <div class="download-app-link">
                                <a href="#" class="download-btn"><img src="images/app-store.png" alt=""></a>
                                <a href="#" class="download-btn"><img src="images/google-play.png" alt=""></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="footer-copyright-text">
                            <p class="mb-0">© 2024, <strong>Barren</strong>. All rights reserved. Powered by Gambolthemes</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer End -->

   <!-- <script src="js/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/OwlCarousel/owl.carousel.js"></script>
    <script src="vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/night-mode.js"></script> -->

    <script>
        // Fee Calculation Script
        let eventType = 'free'; // default
        let feeHandling = 'pass'; // default

        // Toggle buttons
        document.querySelectorAll('.btn-toggle[data-type]').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.btn-toggle[data-type]').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                eventType = btn.dataset.type;
                document.getElementById('ticket-price-group').style.display = eventType === 'paid' ? 'block' : 'none';
                document.getElementById('payment-group').style.display = eventType === 'paid' ? 'block' : 'none';
                calculateFees();
            });
        });

        document.querySelectorAll('.btn-toggle[data-handling]').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.btn-toggle[data-handling]').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                feeHandling = btn.dataset.handling;
                calculateFees();
            });
        });

        // Input listeners
        document.getElementById('ticketPrice').addEventListener('input', calculateFees);
        document.getElementById('ticketQty').addEventListener('input', calculateFees);

        function calculateFees() {
            const price = parseFloat(document.getElementById('ticketPrice').value) || 0;
            const qty = parseInt(document.getElementById('ticketQty').value) || 0;
            const baseTotal = price * qty;

            let serviceFee = 0;
            let processingFee = 0;
            if (eventType === 'paid') {
                serviceFee = baseTotal * 0.05; // 5% service fee
                processingFee = (baseTotal * 0.029) + (qty * 0.30); // 2.9% + $0.30 per ticket
            }

            let totalPay = baseTotal;
            if (feeHandling === 'pass') {
                totalPay += serviceFee + processingFee;
            } // else absorbed: buyer pays only base

            document.getElementById('baseTotal').textContent = `USD ${baseTotal.toFixed(2)}`;
            document.getElementById('serviceFee').textContent = `USD ${serviceFee.toFixed(2)}`;
            document.getElementById('processingFee').textContent = `USD ${processingFee.toFixed(2)}`;
            document.getElementById('totalPay').textContent = `USD ${totalPay.toFixed(2)}`;
            document.getElementById('perTicket').textContent = `USD ${ (totalPay / qty || 0).toFixed(2) }`;
        }

        function simulatePurchase() {
            // Redirect to checkout or show modal
            alert('Simulating purchase... Total: ' + document.getElementById('totalPay').textContent);
            // window.location.href = 'checkout.html'; // Uncomment for real flow
        }

        // Initial calculation
        calculateFees();
    </script>
@endsection
