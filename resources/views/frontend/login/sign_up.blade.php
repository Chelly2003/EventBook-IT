@extends('frontend.master')

@section('title', 'Sign Up - Event Book-IT')
<?php $hideFooter = true; ?>
<?php $hideHeader = true; ?>



<div class="form-wrapper">
    <div class="app-form">
        <div class="app-form-sidebar">
            <div class="sidebar-sign-logo">
                <img src="{{ asset('images/eventlogo.png') }}" alt="">
            </div>
            <div class="sign_sidebar_text">
                <h1>The Easiest Way to Create Events and Sell More Tickets Online</h1>
            </div>
        </div>

        <div class="app-form-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10 col-md-10">
                        <div class="app-top-items">
                            <a href="{{ url('/') }}">
                                <div class="sign-logo" id="logo">
                                    <img src="{{ asset('images/logo.svg') }}" alt="">
                                    <img class="logo-inverse" src="{{ asset('images/dark-logo.svg') }}" alt="">
                                </div>
                            </a>
                            <div class="app-top-right-link">
                                Already Registered? <a href="{{ route('login') }}">Sign in</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-5 col-lg-6 col-md-7">
                        <div class="registration">

                            {{-- Global success message --}}
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <h2 class="registration-title">New here? Sign up..</h2>

                                {{-- Full Name --}}
                                <div class="form-group mt-4">
                                    <label class="form-label">Full Name*</label>
                                    <input
                                        class="form-control h_50 @error('name') is-invalid @enderror"
                                        type="text"
                                        name="name"
                                        value="{{ old('name') }}"
                                        placeholder="Enter your full name"
                                        required>
                                    @error('name')
                                        <div class="invalid-feedback">⚠️ {{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Email --}}
                                <div class="form-group mt-4">
                                    <label class="form-label">Your Email*</label>
                                    <input
                                        class="form-control h_50 @error('email') is-invalid @enderror"
                                        type="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        placeholder="Enter your email"
                                        required>
                                    @error('email')
                                        <div class="invalid-feedback">⚠️ {{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Phone --}}
                                <div class="form-group mt-4">
                                    <label class="form-label">Phone Number</label>
                                    <input
                                        class="form-control h_50 @error('phone') is-invalid @enderror"
                                        type="tel"
                                        name="phone"
                                        value="{{ old('phone') }}"
                                        placeholder="Enter your phone number">
                                    @error('phone')
                                        <div class="invalid-feedback">⚠️ {{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Role --}}
                                <div class="form-group mt-4">
                                    <label class="form-label">Register As*</label>
                                    <select
                                        class="form-control h_50 @error('role') is-invalid @enderror"
                                        name="role"
                                        id="roleSelect"
                                        required>
                                        <option value="">Select Role</option>
                                        <option value="attendee"  {{ old('role') == 'attendee'  ? 'selected' : '' }}>Attendee</option>
                                        <option value="organizer" {{ old('role') == 'organizer' ? 'selected' : '' }}>Organizer</option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">⚠️ {{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Organizer-only fields --}}
                                <div id="organizationFields" style="display: none;">
                                    <div class="form-group mt-4">
                                        <label class="form-label">Organization Name*</label>
                                        <input
                                            class="form-control h_50 @error('organization_name') is-invalid @enderror"
                                            type="text"
                                            name="organization_name"
                                            value="{{ old('organization_name') }}"
                                            placeholder="Enter Organization name">
                                        @error('organization_name')
                                            <div class="invalid-feedback">⚠️ {{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mt-4">
                                        <label class="form-label">KRA PIN*</label>
                                        <input
                                            class="form-control h_50 @error('kra_pin') is-invalid @enderror"
                                            type="text"
                                            name="kra_pin"
                                            id="kra_pin"
                                            value="{{ old('kra_pin') }}"
                                            placeholder="e.g. A123456789B">
                                        @error('kra_pin')
                                            <div class="invalid-feedback">⚠️ {{ $message }}</div>
                                        @enderror
                                    </div>

                                    <button type="button" class="btn btn-primary mt-3" id="verify_kra_btn">
                                        Verify KRA PIN
                                    </button>
                                    <div id="kra_result" class="mt-2"></div>
                                </div>

                                {{-- Password --}}
                                <div class="form-group mt-4">
                                    <label class="form-label">Password*</label>
                                    <div class="loc-group position-relative">
                                        <input
                                            class="form-control h_50 @error('password') is-invalid @enderror"
                                            type="password"
                                            name="password"
                                            id="password"
                                            placeholder="Create password"
                                            required>
                                        <span class="pass-show-eye" onclick="togglePassword('password', this)">
                                            <i class="fas fa-eye-slash"></i>
                                        </span>
                                        @error('password')
                                            <div class="invalid-feedback">⚠️ {{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Confirm Password --}}
                                <div class="form-group mt-4">
                                    <label class="form-label">Confirm Password*</label>
                                    <div class="loc-group position-relative">
                                        <input
                                            class="form-control h_50"
                                            type="password"
                                            name="password_confirmation"
                                            id="password_confirmation"
                                            placeholder="Confirm your password"
                                            required>
                                        <span class="pass-show-eye" onclick="togglePassword('password_confirmation', this)">
                                            <i class="fas fa-eye-slash"></i>
                                        </span>
                                        {{-- Live mismatch warning (JS-driven) --}}
                                        <div id="password_match_msg" class="mt-1" style="font-size: 0.85rem;"></div>
                                    </div>
                                </div>

                                <button class="main-btn btn-hover w-100 mt-5" type="submit">
                                    Register <i class="fas fa-user-plus ms-2"></i>
                                </button>
                            </form>

                            <div class="divider mt-4">
                                <span>or</span>
                            </div>

                            <div class="social-btns-list">
                                <a href="{{ url('/auth/google') }}" class="social-login-btn">
                                    <svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 26.488 27.029">
                                        <g transform="translate(-0.126)">
                                            <path d="M1258.806,1021.475a11.578,11.578,0,0,0-.285-2.763h-12.688v5.015h7.448a6.605,6.605,0,0,1-2.763,4.384l-.025.168,4.012,3.108.278.028a13.214,13.214,0,0,0,4.024-9.941" transform="translate(-1232.192 -1007.66)" fill="#4285f4"/>
                                            <path d="M145.071,1502.921a12.881,12.881,0,0,0,8.949-3.273l-4.265-3.3a8,8,0,0,1-4.685,1.352,8.136,8.136,0,0,1-7.688-5.616l-.158.013-4.172,3.229-.055.152a13.5,13.5,0,0,0,12.073,7.448" transform="translate(-131.431 -1475.893)" fill="#34a853"/>
                                            <path d="M5.952,689.263a8.32,8.32,0,0,1-.45-2.673,8.744,8.744,0,0,1,.435-2.673l-.008-.179-4.224-3.28-.138.066a13.486,13.486,0,0,0,0,12.133l4.385-3.393" transform="translate(0 -673.076)" fill="#fbbc05"/>
                                            <path d="M145.071,5.225A7.49,7.49,0,0,1,150.3,7.238l3.814-3.724A12.984,12.984,0,0,0,145.071,0,13.5,13.5,0,0,0,133,7.448l4.37,3.394a8.169,8.169,0,0,1,7.7-5.616" transform="translate(-131.431)" fill="#eb4335"/>
                                        </g>
                                    </svg>
                                    Sign up with Google
                                </a>
                            </div>

                            <div class="new-sign-link mt-4">
                                Already have an account? 
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
// ── Show/hide organizer fields ─────────────────────────────────
document.getElementById("roleSelect").addEventListener("change", function () {
    document.getElementById("organizationFields").style.display =
        (this.value === "organizer") ? "block" : "none";

    // Reset verification when role changes
    kraVerified = false;
    document.getElementById("kra_result").innerHTML = "";
});

window.addEventListener('load', function () {
    if (document.getElementById("roleSelect").value === "organizer") {
        document.getElementById("organizationFields").style.display = "block";
    }
});

// ── Live password match check ──────────────────────────────────
document.getElementById("password_confirmation").addEventListener("input", function () {
    const pass    = document.getElementById("password").value;
    const confirm = this.value;
    const msg     = document.getElementById("password_match_msg");

    if (confirm === "") {
        msg.innerHTML = "";
    } else if (pass === confirm) {
        msg.innerHTML = `<span style="color: green;">✅ Passwords match</span>`;
    } else {
        msg.innerHTML = `<span style="color: red;">❌ Passwords do not match</span>`;
    }
});

// ── Toggle password visibility ─────────────────────────────────
function togglePassword(fieldId, icon) {
    const field = document.getElementById(fieldId);
    const i     = icon.querySelector("i");
    if (field.type === "password") {
        field.type = "text";
        i.classList.replace("fa-eye-slash", "fa-eye");
    } else {
        field.type = "password";
        i.classList.replace("fa-eye", "fa-eye-slash");
    }
}

// ── KRA PIN Verification ───────────────────────────────────────
let kraVerified = false; // ← tracks whether PIN has been verified

// Reset verification if user edits the PIN after verifying
document.getElementById("kra_pin").addEventListener("input", function () {
    kraVerified = false;
    document.getElementById("kra_result").innerHTML = "";
});

document.getElementById("verify_kra_btn").addEventListener("click", function () {
    const pin    = document.getElementById("kra_pin").value.trim().toUpperCase();
    const result = document.getElementById("kra_result");
    const btn    = this;

    if (!pin) {
        result.innerHTML = `<div class="alert alert-warning mt-2">Please enter a KRA PIN first.</div>`;
        return;
    }

    if (!/^[A-Z]\d{9}[A-Z]$/.test(pin)) {
        result.innerHTML = `<div class="alert alert-warning mt-2">Invalid PIN format. Example: <strong>A123456789B</strong></div>`;
        return;
    }

    btn.disabled  = true;
    btn.innerHTML = `<span class="spinner-border spinner-border-sm me-1"></span> Verifying...`;
    result.innerHTML = `<div class="alert alert-info mt-2">⏳ Checking PIN with KRA, please wait...</div>`;

    fetch("{{ route('kra.validate') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN":  "{{ csrf_token() }}"
        },
        body: JSON.stringify({ kra_pin: pin })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            const d = data.data || {};
            kraVerified = true; // ✅ Mark as verified
            result.innerHTML = `
                <div class="alert alert-success mt-2">
                    ✅ <strong>Valid KRA PIN</strong><br>
                    Name: <strong>${d.Name ?? 'N/A'}</strong><br>
                    Type: <strong>${d.TypeOfTaxpayer ?? 'N/A'}</strong><br>
                    Status: <strong>${d.StatusOfPIN ?? 'N/A'}</strong>
                </div>`;
        } else {
            kraVerified = false;
            result.innerHTML = `
                <div class="alert alert-danger mt-2">
                    ❌ ${data.message ?? 'Invalid KRA PIN. Please check and try again.'}
                </div>`;
        }
    })
    .catch(() => {
        kraVerified = false;
        result.innerHTML = `<div class="alert alert-danger mt-2">⚠️ Network error. Please try again.</div>`;
    })
    .finally(() => {
        btn.disabled  = false;
        btn.innerHTML = `Verify KRA PIN`;
    });
});

// ── Block form submission if organizer PIN not verified ────────
document.querySelector("form").addEventListener("submit", function (e) {
    const role = document.getElementById("roleSelect").value;

    if (role === "organizer" && !kraVerified) {
        e.preventDefault(); // Stop form from submitting

        const result = document.getElementById("kra_result");
        result.innerHTML = `
            <div class="alert alert-danger mt-2">
                ⚠️ You must verify your KRA PIN before registering as an Organizer.
            </div>`;

        // Scroll to the KRA section so user sees the warning
        document.getElementById("kra_pin").scrollIntoView({ behavior: "smooth", block: "center" });
    }
});
</script>

