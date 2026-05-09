@extends('frontend.master')

@section('title', 'Create Online Event')

@section('content')

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
    </style>
<!--herosection -->
<section class="create-hero">
        <div class="container">
            <h1>Create Online Event</h1>
            <p>Host unlimited online events with built-in Zoom links and seamless ticketing</p>
        </div>
    </section>

    <!-- Create Form -->

    <section class="form-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="form-card">
                        <form id="createOnlineEventForm" action="{{ route('events.online.store') }}" method="POST" enctype="multipart/form-data">
                              @csrf
                      <!--        <div class="alert alert-danger" style="background:#fee2e2; border:2px solid red; padding:20px; margin-bottom:30px; font-weight:bold;" role="alert">
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
    @endif -->
                            <!-- Event Title -->
                            <div class="form-group">
                                <label>Event Title *</label>
                                <input type="text" required placeholder="e.g., Step Up Open Mic – November Edition" name="title" required>
                            </div>

                            <!-- Description -->
                            <div class="form-group">
                                <label>Description *</label>
                                <textarea rows="5" required placeholder="Tell attendees what to expect..." name="description" required></textarea>
                            </div>

                            <!-- Date & Time -->
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>Event Date *</label>
                                    <input type="date" name="event_date" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Event Time *</label>
                                    <input type="time" name="event_time"required>
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

                            <!--online platform -->
                              <div class="form-group">
                                <label>Online Event platform (Zoom, Google Meet, etc.) *</label>
                                <input type="text" required placeholder="Zoom,Google meet..." name="online_platform">
                            </div>

                            <!-- Online Event URL (Zoom, Google Meet, etc.) -->
                            <div class="form-group">
                                <label>Online Event Link (Zoom, Google Meet, etc.) *</label>
                                <input type="url" required placeholder="https://zoom.us/j/1234567890" name="meeting_link">
                            </div>

                            <!-- Event Banner -->
                            <div class="form-group">
                                <label>Event Banner (1920×1080 recommended)</label>
                                <input type="file" accept="image/*" id="bannerUpload" name="banner">
                                <img id="bannerPreview" class="upload-preview" alt="Preview">
                            </div>

                            <hr>

                            <!-- Ticket Settings -->
                            <h4 class="mb-4">Ticket & Pricing</h4>

                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>Is this a Free or Paid event? *</label>
                                    <select id="eventType"  name="payment_type" required>
                                        <option value="free">Free Event</option>
                                        <option value="paid">Paid Event</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group" id="priceGroup">
                                    <label>Ticket Price (KSH) *</label>
                                    <input type="number" step="0.01" min="0" placeholder="50.00" name="price">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>How do you want to handle service fees?</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="fee_handling" value="pass" checked>
                                        <label class="form-check-label">Pass on to buyer (recommended)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="fee_handling" value="absorb">
                                        <label class="form-check-label">Absorb (I pay the fees)</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Maximum Attendees</label>
                                <input type="number" min="1" value="100" placeholder="Unlimited if left empty" name="capacity">
                            </div>

                            <div class="text-center mt-5">
                                <button type="submit" class="btn btn-create">
                                    <i class="fas fa-paper-plane me-2"></i> Publish Event
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer (same as your other pages) -->
    <footer class="footer mt-auto">
        <!-- Your existing footer code here -->
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
    <script src="/js/custom.js"></script>
    <script src="/js/night-mode.js"></script>-->

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
