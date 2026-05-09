@extends('frontend.master')

<?php $hideFooter = true; ?>
@section('title', 'Edit Event - ' . $event->title)

@section('content')

@include('frontend.layouts.header-edit')

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">





</head>


    <!-- Bootstrap JS -->








<!--static code-->

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">

                <div class="main-card p-4 p-lg-5 shadow-sm border-0">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="mb-0">Edit Event</h3>
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                           <button onclick="window.history.back()" class="btn btn-secondary">
    ← Back
</button>
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Whoops! Something went wrong.</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('events.update', $event->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Event Title -->
                        <div class="mb-4">
                            <label for="title" class="form-label fw-bold">Event Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title', $event->title) }}" required autofocus>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Event Date -->
                        <div class="mb-4">
                            <label for="event_date" class="form-label fw-bold">Event Date <span class="text-danger">*</span></label>
                            <input type="date" name="event_date" id="event_date" class="form-control @error('event_date') is-invalid @enderror"
                                   value="{{ old('event_date', $event->event_date ? $event->event_date->format('Y-m-d') : '') }}" required>
                            @error('event_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Event Time -->
                        <div class="mb-4">
                            <label for="event_time" class="form-label fw-bold">Event Time <span class="text-danger">*</span></label>
                            <input type="time" name="event_time" id="event_time" class="form-control @error('event_time') is-invalid @enderror"
                                   value="{{ old('event_time', $event->event_time ? $event->event_time->format('H:i') : '') }}" required>
                            @error('event_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div class="mb-4">
                            <label for="price" class="form-label fw-bold">Ticket Price (KES) <span class="text-muted">(leave blank for free)</span></label>
                            <input type="number" name="price" id="price" step="0.01" min="0" class="form-control @error('price') is-invalid @enderror"
                                   value="{{ old('price', $event->price ?? '') }}">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Location / Venue Name -->
                        <div class="mb-4">
                            <label for="venue" class="form-label fw-bold">Venue / Location</label>
                            <input type="text" name="venue" id="venue" class="form-control @error('venue') is-invalid @enderror"
                                   value="{{ old('venue', $event->venue ?? $event->location ?? '') }}">
                            @error('venue')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">Event Description</label>
                            <textarea name="description" id="description" rows="6" class="form-control @error('description') is-invalid @enderror">{{ old('description', $event->description ?? '') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Banner / Image Upload -->
                        <div class="mb-5">
                            <label for="image" class="form-label fw-bold">Event Banner / Featured Image</label>
                            <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if ($event->image)
                                <div class="mt-3">
                                    <small>Current image:</small><br>
                                    <img src="{{ asset('storage/' . $event->image) }}" alt="Current banner" class="img-thumbnail" style="max-height: 180px;">
                                </div>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-3 flex-wrap">
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                <i class="fa-solid fa-save me-2"></i>Save Changes
                            </button>
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-lg px-5">
                                <i class="fa-solid fa-arrow-left me-2"></i>Cancel
                            </a>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
