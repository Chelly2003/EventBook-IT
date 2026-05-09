@extends('frontend.master')

@section('title', 'Create Venue Event')

@section('content')

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=9">
    <title>Barren - Create Venue Event</title>

    <!-- Same styles as all your pages -->
    <link rel="icon" type="image/png" href="images/fav.png">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link href='vendor/unicons-2.0.1/css/unicons.css' rel='stylesheet'>
    <link href="css/style.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">
    <link href="css/night-mode.css" rel="stylesheet">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .create-hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 80px 0;
            text-align: center;
        }
        .form-section { padding: 60px 0; }
        .form-card { background: white; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); padding: 40px; }
        .form-group { margin-bottom: 25px; }
        .form-group label { font-weight: 600; margin-bottom: 8px; display: block; }
        .form-group input, .form-group textarea, .form-group select {
            width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px;
        }
        .btn-create {
            background: #28a745; color: white; padding: 12px 40px; font-size: 1.1rem; border-radius: 50px;
        }
        .btn-create:hover { background: #218838; }
        .upload-preview {
            margin-top: 15px;
            max-width: 100%;
            max-height: 300px;
            border-radius: 10px;
            display: none;
        }
        .map-preview {
            width: 100%;
            height: 300px;
            border-radius: 10px;
            margin-top: 15px;
            border: 1px solid #ddd;
        }
    </style>

    <!-- Hero -->
    <section class="create-hero">
        <div class="container">
            <h1>Create Venue Event</h1>
            <p>Host in-person events at any location in Kenya or worldwide</p>
        </div>
    </section>

    <!-- Create Venue Event Form -->
    <section class="form-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="form-card">
                        <form id="createVenueEventForm" action="{{ route('events.venue.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <!--
<div class="alert alert-danger" style="background:#fee2e2; border:2px solid red; padding:20px; margin-bottom:30px; font-weight:bold;" role="alert">
    @if ($errors->any())
        <h4 style="margin:0 0 15px 0; color:#991b1b;">FORM ERRORS ({{ $errors->count() }} found):</h4>
        <ul style="margin:0; padding-left:25px;">
            @foreach ($errors->all() as $error)
                <li style="margin-bottom:8px; color:#991b1b;">{{ $error }}</li>
            @endforeach
        </ul>
    @else
        <p style="color:#155724; background:#d4edda; padding:10px; border:1px solid #c3e6cb; border-radius:4px;">
            No validation errors detected on this page load.
        </p>
    @endif
</div> -->
                            <!-- Event Title -->
                            <div class="form-group">
                                <label>Event Title *</label>
                                <input type="text" required placeholder="e.g., Nairobi Tech Summit 2025" name="title">
                            </div>

                            <!-- Description -->
                            <div class="form-group">
                                <label>Description *</label>
                                <textarea rows="5" required placeholder="What will happen? Who should attend?" name="description"></textarea>
                            </div>

                            <!-- Date & Time -->
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>Event Date *</label>
                                    <input type="date" name="event_date" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Event Time *</label>
                                    <input type="time" name="event_time" required>
                                </div>
                            </div>
<div class="row">
    <!-- Main Event Type (required dropdown – powers homepage tabs) -->
    <div class="col-md-6 form-group">
        <label>Event Category / Type *</label>
        <select name="event_category" class="form-control form-control-lg" required>
            <option value="">-- Select Category --</option>
            <option value="arts">Arts</option>
            <option value="business">Business</option>
            <option value="concert">Concert / Music</option>
            <option value="workshops">Workshops</option>
            <option value="coaching">Coaching and Consulting</option>
            <option value="health">Health and Wellbeing</option>
            <option value="volunteer">Volunteer / Community</option>
            <option value="sports">Sports</option>
            <option value="other">Other</option>
        </select>
        @error('event_category')
            <span class="text-danger small">{{ $message }}</span>
        @enderror
        <small class="text-muted">This helps attendees find your event in filters like "Business" or "Arts"</small>
    </div>

    <!-- Optional: Extra Tags (multi-select for more detail) -->
    <div class="col-md-6 form-group">
        <label>Additional Tags (optional – select all that apply)</label>
        <select name="tags[]" class="form-control" multiple size="6">
            <option value="concert">Live Music / Concert</option>
            <option value="seminar">Seminar / Talk</option>
            <option value="networking">Networking</option>
            <option value="yoga">Yoga / Fitness</option>
            <option value="art_exhibition">Art Exhibition</option>
            <option value="charity">Charity / Fundraising</option>
            <!-- Add more relevant ones -->
        </select>
        <small class="text-muted">Hold Ctrl/Cmd to select multiple. Helps with detailed search.</small>
        @error('tags.*')
            <span class="text-danger small">{{ $message }}</span>
        @enderror
    </div>
</div>
                            <!-- Venue Details -->
                            <hr>
                            <h4 class="mb-4">Venue Information</h4>

                            <div class="form-group">
                                <label>Venue Name *</label>
                                <input type="text" placeholder="e.g., KICC, iHub Nairobi, Sarit Centre" name="venue_name" required >
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>Address Line 1 *</label>
                                    <input type="text" required placeholder="Harambee Avenue" name="address_line1">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Address Line 2 (optional)</label>
                                    <input type="text" placeholder="P.O. Box 12345" name="address_line2">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label>City *</label>
                                    <input type="text"  value="Nairobi"name="city" required>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>County / State</label>
                                    <input type="text" placeholder="Nairobi County" name="county" required>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Country *</label>
                                    <select name="country" required>
                                        <option value="KE">Kenya</option>
                                        <option value="TZ">Tanzania</option>
                                        <option value="UG">Uganda</option>
                                        <option value="RW">Rwanda</option>
                                        <option value="OTHER">Other</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Google Maps Link -->
                            <div class="form-group">
                                <label>Google Maps Link (optional but recommended)</label>
                                <input type="url" placeholder="https://maps.google.com/?q=KICC+Nairobi" name="google_maps_url">
                                <small class="text-muted">Attendees will click this to get directions</small>
                            </div>

                            <!-- Venue Capacity -->
                            <div class="form-group">
                                <label>Venue Capacity (max attendees)</label>
                                <input type="number" min="1" placeholder="e.g., 500" name="capacity" required>
                            </div>

                            <!-- Event Banner -->
                            <div class="form-group">
                                <label> Event Banner (1920×1080 recommended)</label>
                                <input type="file" accept="image/*" id="bannerUpload" name="banner">
                                <img id="bannerPreview" class="upload-preview" alt="Banner preview">
                            </div>

                            <hr>

                            <!-- Ticket & Pricing -->
                            <h4 class="mb-4">Ticket & Pricing</h4>

                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>Free or Paid Event? *</label>
                                    <select id="eventType" name="payment_type"required>
                                        <option value="free">Free Event</option>
                                        <option value="paid">Paid Event</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group" id="priceGroup">
                                    <label>Ticket Price (KSH)</label>
                                    <input type="number" step="0.01" min="0" placeholder="2500.00" name="price">

                                </div>
                            </div>

                            <div class="form-group">
                                <label>Service Fee Handling</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="fee_handling" value="pass" checked>
                                        <label class="form-check-label">Pass fees to buyer (recommended)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="fee_handling" value="absorb">
                                        <label class="form-check-label">Absorb fees myself</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit -->
                            <div class="text-center mt-5">
                                <button type="submit" class="btn btn-create">
                                    <i class="fas fa-paper-plane me-2"></i> Publish Venue Event
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer mt-auto">
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-copyright-text">
                    <p class="mb-0">© 2025, <strong>Barren</strong>. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts
    <script src="js/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/night-mode.js"></script>-->

  <script>
        // Show/hide price field
        document.getElementById('eventType').addEventListener('change', function() {
            document.getElementById('priceGroup').style.display = this.value === 'paid' ? 'block' : 'none';
        });

        // Banner preview
        document.getElementById('bannerUpload').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(ev) {
                    const preview = document.getElementById('bannerPreview');
                    preview.src = ev.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });

    </script>
@endsection
