@extends('frontend.master')

@section('title', 'Attendee Profile')

@section('content')

<div class="wrapper">
    <div class="profile-banner">
        <!-- Hero Cover -->
        <div class="hero-cover-block">
            <div class="hero-cover">
                <div class="hero-cover-img"
                     style="background-image: url('{{ Auth::user()->cover_image ? asset(Auth::user()->cover_image) : '#' }}');
                            background-size: cover; background-position: center; min-height: 300px;">
                </div>
            </div>
            <div class="upload-cover">
                <div class="container">
                    <div class="row">
                        <!-- <div class="col-12">
                            <div class="cover-img-btn">
                                <input type="file" id="cover-img" name="cover_image" form="attendeeProfileForm">
                                <label for="cover-img"><i class="fa-solid fa-panorama me-3"></i>Change Cover Image</label>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="user-dt-block">
            <div class="container">
                <div class="row">

                    <!-- Left Sidebar -->
                    <div class="col-xl-4 col-lg-5 col-md-12">
                        <div class="main-card user-left-dt">
                            <div class="user-avatar-img">
                                <img src="{{ Auth::user()->avatar ? asset(Auth::user()->avatar) : asset('images/profile-imgs/img-13.jpg') }}"
                                     alt="Profile Picture">
                                <div class="avatar-img-btn">
                                    <input type="file" id="avatar-img" name="avatar" form="attendeeProfileForm">
                                    <label for="avatar-img"><i class="fa-solid fa-camera"></i></label>
                                </div>
                            </div>

                            <div class="user-dts mt-3">
                                <h4 class="user-name">{{ Auth::user()->name }}
                                    <span class="verify-badge"><i class="fa-solid fa-circle-check"></i></span>
                                </h4>
                                <span class="user-email">{{ Auth::user()->email }}</span>
                            </div>

                            <div class="ff-block">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#FFModal"><span>0</span> Followers</a>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#FFModal"><span>2</span> Following</a>
                            </div>

                            <div class="user-description">
                                <p>Hey, I'm an event enthusiast!</p>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side - Tabs -->
                    <div class="col-xl-8 col-lg-7 col-md-12">
                        <div class="right-profile">
                            <div class="profile-tabs">

                                <!-- Outer Tabs-->
                                <ul class="nav nav-pills nav-fill p-2 garren-line-tab" id="myTab" role="tablist">
                                   <!--  <li class="nav-item" role="presentation">

                                        <button class="nav-link active" id="feed-tab" data-bs-toggle="tab" data-bs-target="#feed" type="button" role="tab" aria-controls="feed" aria-selected="true">
                                            <i class="fa-solid fa-house"></i> Home
                                        </button>
                                    </li>
                                    -->
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="about-tab" data-bs-toggle="tab" data-bs-target="#about" type="button" role="tab" aria-controls="about" aria-selected="false">
                                            <i class="fa-solid fa-circle-info"></i> About
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="setting-tab" data-bs-toggle="tab" data-bs-target="#setting" type="button" role="tab" aria-controls="setting" aria-selected="false">
                                            <i class="fa-solid fa-gear"></i> Settings
                                        </button>
                                    </li>
  <!--
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders" type="button" role="tab" aria-controls="orders" aria-selected="false">
                                            <i class="fa-solid fa-box"></i> My Orders
                                        </button>
                                    </li>

-->
                                </ul>

                                <!-- Tab Contents -->
                                <div class="tab-content mt-3" id="myTabContent">

                                    <!-- Feed Tab -->
                                     <!--
                                    <div class="tab-pane fade show active" id="feed" role="tabpanel" aria-labelledby="feed-tab">
                                        <div class="nav my-event-tabs mt-4" role="tablist">
                                            <button class="event-link active" data-bs-toggle="tab" data-bs-target="#saved" type="button" role="tab" aria-controls="saved" aria-selected="true">
                                                <span class="event-count">1</span><span>Saved Events</span>
                                            </button>
                                            <button class="event-link" data-bs-toggle="tab" data-bs-target="#attending" type="button" role="tab" aria-controls="attending" aria-selected="false">
                                                <span class="event-count">1</span><span>Attending Events</span>
                                            </button>
                                        </div>

                                        <div class="tab-content mt-3">
                                            <div class="tab-pane fade show active" id="saved" role="tabpanel">
                                                <!-- Saved Events Content
                                                <p class="p-4">Your saved events will appear here.</p>
                                            </div>
                                            <div class="tab-pane fade" id="attending" role="tabpanel">
                                                <p class="p-4">Events you're attending will appear here.</p>
                                            </div>
                                        </div>
                                    </div>
-->
                                    <!-- About Tab -->
                                    <div class="tab-pane fade" id="about" role="tabpanel" aria-labelledby="about-tab">
                                        <div class="main-card mt-4">
                                            <div class="bp-title position-relative">
                                                <h4>About</h4>
                                                <button class="main-btn btn-hover ms-auto edit-btn me-3 pe-4 ps-4 h_40" data-bs-toggle="modal" data-bs-target="#aboutModal">
                                                    <i class="fa-regular fa-pen-to-square me-2"></i>Edit
                                                </button>
                                            </div>
                                            <div class="about-details p-4">
                                                <div class="about-step">
                                                    <h5>Name</h5>
                                                    <span>{{ Auth::user()->name }}</span>
                                                </div>
                                                <div class="about-step">
                                                    <h5>Email</h5>
                                                    <span>{{ Auth::user()->email }}</span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- Settings Tab -->
                                    <div class="tab-pane fade" id="setting" role="tabpanel" aria-labelledby="setting-tab">
                                        <div class="main-card mt-4">
                                            <div class="p-4">
                                                <h4 class="mb-4">Profile & Account Settings</h4>

                                                <form id="attendeeProfileForm" action="{{ route('account.update') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="row">
                                                        <!-- Avatar -->
                                                        <div class="col-md-6 mb-4">
                                                            <label class="form-label fw-bold">Profile Picture</label>
                                                            <div class="text-center mb-3">
                                                                <img src="{{ Auth::user()->avatar ? asset(Auth::user()->avatar) : asset('images/profile-imgs/img-13.jpg') }}"
                                                                     alt="Avatar"
                                                                     class="rounded-circle border"
                                                                     style="width: 160px; height: 160px; object-fit: cover;">
                                                            </div>
                                                            <input type="file" name="avatar" class="form-control" accept="image/*">
                                                            <small class="text-muted">Square image recommended</small>
                                                        </div>

                                                        <!-- Cover Image -->
                                                        <div class="col-md-6 mb-4">
                                                            <label class="form-label fw-bold">Cover / Hero Image</label>
                                                            <div class="mb-3">
                                                                @if(Auth::user()->cover_image)
                                                                    <img src="{{ asset(Auth::user()->cover_image) }}"
                                                                         alt="Cover"
                                                                         class="img-fluid rounded border"
                                                                         style="max-height: 200px; width: 100%; object-fit: cover;">
                                                                @else
                                                                    <div class="bg-light border rounded d-flex align-items-center justify-content-center" style="height: 200px;">
                                                                        <p class="text-muted">No cover image yet</p>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <input type="file" name="cover_image" class="form-control" accept="image/*">
                                                            <small class="text-muted">Wide banner recommended</small>
                                                        </div>
                                                    </div>

                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label">Full Name</label>
                                                            <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Phone Number</label>
                                                            <input type="text" name="phone" class="form-control" value="{{ Auth::user()->phone ?? '' }}">
                                                        </div>
                                                    </div>

                                                    <div class="mt-4">
                                                        <button type="submit" class="btn btn-primary btn-lg">
                                                            <i class="fa-solid fa-save me-2"></i> Save Changes
                                                        </button>
                                                    </div>
                                                </form>

                                                <hr class="my-5">

                                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                                                    <i class="fa-solid fa-trash me-2"></i> Delete My Account
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Orders Tab -->


                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('account.delete') }}" method="POST" class="modal-content">
            @csrf
            @method('DELETE')
            <div class="modal-header">
                <h5 class="modal-title text-danger">Delete Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-danger">
                    Are you sure you want to permanently delete your account?<br><br>
                    <strong>This action cannot be undone.</strong>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Yes, Delete My Account</button>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript Fix for Tabs -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Initialize Bootstrap Tabs
    const tabTriggers = document.querySelectorAll('#myTab button');
    tabTriggers.forEach(tab => new bootstrap.Tab(tab));

    // Handle hash in URL (e.g., #setting)
    const hash = window.location.hash;
    if (hash) {
        const targetTab = document.querySelector(`#myTab button[data-bs-target="${hash}"]`);
        if (targetTab) {
            bootstrap.Tab.getOrCreateInstance(targetTab).show();
        }
    }
});
</script>

@endsection
