<header class="header">
    <div class="header-inner">
        <nav class="navbar navbar-expand-lg bg-barren barren-head fixed-top justify-content-sm-start pt-0 pb-0">
            <div class="container">

                <!-- Toggler -->
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <i class="fa-solid fa-bars"></i>
                    </span>
                </button>


                <a class="navbar-brand order-1 order-lg-0 ms-lg-0 ms-2 me-auto" href="{{ route('home') }}">
                    <div class="res-main-logo">
                        <img src="images/eventlogo.png" alt="Logo icon">
                    </div>
                    <div class="main-logo" id="logo">
                        <img src="images/eventlogo.png" alt="Main logo" style="height:55px">
                        <img class="logo-inverse" src="images/dark-logo.svg" alt="Dark logo">
                    </div>
                </a>

                <!-- Offcanvas mobile menu -->
                <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                        <div class="offcanvas-logo" id="offcanvasNavbarLabel">
                            <img src="images/eventlogo.png" alt="Logo">
                        </div>
                        <button type="button" class="close-btn" data-bs-dismiss="offcanvas" aria-label="Close">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>

                  <div class="offcanvas-body">


                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-5">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{ route('home') }}">Home</a>
                            </li>
                         <!--   <li class="nav-item dropdown">-->
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page"  href="{{ route('exploreevents') }}">
                                    Explore Events
                                </a>
                                  </li>
                               <!--<ul class="dropdown-menu dropdown-submenu">
                                    <li><a class="dropdown-item" href="{{ route('exploreevents') }}">Explore Events</a></li>

                                </ul>
                            </li>-->
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ route('pricing') }}">Pricing</a>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Help
                                </a>
                                <ul class="dropdown-menu dropdown-submenu">
                                    <li><a class="dropdown-item" href="{{ route('faq') }}">FAQ</a></li>

                                </ul>
                            </li>

                                    <!-- ... other submenus ... -->
                                    <!-- Keep all your existing submenu blocks here -->
                                </ul>
                            </li>
                        </ul>

                        <div class="offcanvas-footer">
                            <div class="offcanvas-social">
                                <h5>Follow Us</h5>
                                <ul class="social-links">
                                    <li><a href="#" class="social-link"><i class="fab fa-facebook-square"></i></a></li>
                                    <li><a href="#" class="social-link"><i class="fab fa-instagram"></i></a></li>
                                    <li><a href="#" class="social-link"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a></li>
                                    <li><a href="#" class="social-link"><i class="fab fa-youtube"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right side (desktop) -->
                <div class="right-header order-2">
                    <ul class="align-self-stretch d-flex align-items-center">
                       <!-- <li>
                            <a href="{{ route('createevent') }}" class="create-btn btn-hover">
                                <i class="fa-solid fa-calendar-days"></i>
                                <span>Create Event</span>
                            </a>
                        </li> -->

                        <li class="dropdown account-dropdown ms-3">
                            <a href="#" class="account-link" role="button" id="accountClick"
                               data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                @if (Auth::check())
                                    <img src="{{ Auth::user()->profile_photo_url ?? 'images/profile-imgs/img-13.jpg' }}"
                                         alt="{{ Auth::user()->name ?? 'User' }}">
                                @else
                                    <img src="images/profile-imgs/img-13.jpg" alt="Profile">
                                @endif
                                <i class="fas fa-caret-down arrow-icon"></i>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-account dropdown-menu-end" aria-labelledby="accountClick">


                                  @if (Auth::check())
    <li>
        <div class="dropdown-account-header">
            <div class="account-holder-avatar">
                <img src="{{ Auth::user()->avatar ? asset(Auth::user()->avatar) : asset('images/profile-imgs/img-13.jpg') }}"
                     alt="{{ Auth::user()->name }}">
            </div>
            <h5>{{ Auth::user()->name }}</h5>
            <p>{{ Auth::user()->email }}</p>
        </div>
    </li>
    <li class="profile-link">
        @if(Auth::user()->role === 'attendee')
            <!-- Attendee gets their own profile -->
            <a href="{{ route('attendee') }}" class="link-item">My Profile</a>

            <!-- Upgrade to Organizer -->
            <a href="#" class="link-item" id="upgradeBtn">Register as Organizer</a>
        @else
            <!-- Organizer gets organizer profile -->
            <a href="{{ route('organiserprofile') }}" class="link-item">My Profile</a>
            <a href="{{ route('organiserdashboard') }}" class="link-item">My Organisation</a>
        @endif

        <a href="#" class="link-item"
           onclick="event.preventDefault(); if(confirm('Are you sure you want to logout?')) { document.getElementById('logout-form').submit(); }">
            Logout
        </a>

        <form method="POST" action="{{ route('logout') }}" id="logout-form" style="display: none;">
            @csrf
        </form>
    </li>
@else
    <!-- Guest user -->
    <li class="profile-link text-center">
        <a href="{{ route('login') }}" class="link-item">Sign In</a>
        <a href="{{ route('register') }}" class="link-item">Sign Up</a>
    </li>
@endif
                            </ul>
                        </li>

                        <li class="ms-3">
                            <div class="night_mode_switch__btn">
                                <div id="night-mode" class="fas fa-moon fa-sun"></div>
                            </div>
                        </li>
                    </ul>
                </div>

            </div>
        </nav>

        <div class="overlay"></div>
    </div>
    <!-- Upgrade to Organizer Modal -->
@if(Auth::check() && Auth::user()->role === 'attendee')
<div id="upgradeModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white p-6 rounded-lg w-96">
        <h2 class="text-xl font-bold mb-4">Register as Organizer</h2>
        <form id="upgradeForm">
            @csrf
            <div class="mb-3">
                <label for="organization_name">Organization Name</label>
                <input type="text" id="organization_name" name="organization_name" class="border p-2 w-full" required>
            </div>
            <div class="mb-3">
                <label for="kra_pin">KRA PIN</label>
                <input type="text" id="kra_pin" name="kra_pin" class="border p-2 w-full" required>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" id="closeModal" class="btn btn-secondary">Cancel</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
        <div id="upgradeMessage" class="mt-3 text-sm text-red-500"></div>
    </div>
</div>
@endif

<script>
    const modal = document.getElementById('upgradeModal');
    const btn = document.getElementById('upgradeBtn');
    const closeBtn = document.getElementById('closeModal');
    const form = document.getElementById('upgradeForm');
    const msg = document.getElementById('upgradeMessage');

    btn.addEventListener('click', (e) => {
        e.preventDefault();
        modal.classList.remove('hidden');
    });

    closeBtn.addEventListener('click', () => modal.classList.add('hidden'));

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        msg.textContent = '';

        const data = new FormData(form);

        try {
            const res = await fetch('{{ route("upgrade.organizer") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: data
            });

            const result = await res.json();

            if (result.success) {
                msg.classList.remove('text-red-500');
                msg.classList.add('text-green-500');
                msg.textContent = result.message;
                setTimeout(() => location.reload(), 1500);
            } else {
                msg.classList.remove('text-green-500');
                msg.classList.add('text-red-500');
                msg.textContent = result.message;
            }
        } catch (err) {
            msg.textContent = 'Something went wrong. Try again.';
        }
    });
</script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</header>
