@extends('frontend.dashboard.master')

@section('title', 'Events Corner')

@section('content')

<div class="wrapper wrapper-body">
    <div class="dashboard-body">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-12">
                    <div class="d-main-title">
                        <h3><i class="fa-solid fa-calendar-days me-3"></i>Events</h3>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="main-card mt-5">
                        <div class="dashboard-wrap-content p-4">
                            <h5 class="mb-4">Events ({{ count($events) }})</h5>

                            <div class="d-md-flex flex-wrap align-items-center">
                                <div class="dashboard-date-wrap">
                                    <div class="form-group">
                                        <div class="relative-input position-relative">
                                            <input class="form-control h_40" type="text" placeholder="Search by event name, status">
                                            <i class="uil uil-search"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="rs ms-auto mt_r4">
                                    <div class="nav custom2-tabs btn-group" role="tablist">
                                        <button class="tab-link"
                                            onclick="window.location.href='{{ route('createevent') }}'">
                                            Create Event
                                        </button>

                                        <button class="tab-link active">All Events ({{ count($events) }})</button>
                                        <button class="tab-link">Online Event (0)</button>
                                        <button class="tab-link">Venue Event ({{ count($events) }})</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- EVENT LIST -->
                <div class="col-md-12 mt-4">
                    <ol class="list-group list-group-numbered">

                        @forelse($events as $event)
                        <li class="list-group-item d-flex justify-content-between align-items-start">

                            <div class="ms-2 me-auto">
                                <strong class="fw-bold">{{ $event->title }}</strong><br>
                                <span class="text-muted">
                                    Date: {{ $event->event_date->format('d M Y') }} <br>
                                    Time: {{ $event->event_time->format('g:i A') }} <br>
                                    Price: {{ $event->price ? 'KES ' . number_format($event->price, 2) : 'Free' }}
                                </span>
                            </div>

                            <!-- Update Button -->
                            <button class="btn btn-primary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#updateEventModal{{ $event->id }}">
                                Update
                            </button>

                            <!-- Delete Form -->
                            <form action="{{ route('events.destroy', $event->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete this event?')">
                                    Delete
                                </button>
                            </form>

                        </li>

                        <!-- UPDATE MODAL -->
                        <div class="modal fade" id="updateEventModal{{ $event->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Update Event</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <div class="modal-body">

                                            <div class="mb-3">
                                                <label class="form-label">Event Title</label>
                                                <input type="text" name="title" class="form-control" value="{{ $event->title }}">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Event Date</label>
                                                <input type="date" name="event_date" class="form-control" value="{{ $event->event_date->format('Y-m-d') }}">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Event Time</label>
                                                <input type="time" name="event_time" class="form-control" value="{{ $event->event_time->format('H:i') }}">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Price</label>
                                                <input type="number" name="price" class="form-control" value="{{ $event->price }}">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Change Banner (optional)</label>
                                                <input type="file" name="banner" class="form-control">
                                            </div>

                                        </div>

                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">Save Changes</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty

                        <li class="list-group-item text-center py-4">
                            <h4>No events yet</h4>
                            <a href="{{ route('createevent') }}" class="btn btn-primary mt-3">Create Event</a>
                        </li>

                        @endforelse

                    </ol>
                </div>

            </div>
        </div>
    </div>
</div>


<script src="js/vertical-responsive-menu.min.js"></script>
<script src="js/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/OwlCarousel/owl.carousel.js"></script>
<script src="vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
<script src="js/custom.js"></script>
<script src="js/night-mode.js"></script>

@endsection
