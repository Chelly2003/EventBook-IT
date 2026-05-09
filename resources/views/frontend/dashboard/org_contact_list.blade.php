@extends('frontend.dashboard.master')

@section('title', 'Contact Lists')

@section('content')
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Bundle JS (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Success / Error Messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Create / Edit Contact List Modal -->
<div class="modal fade" id="addContactlistModal" tabindex="-1" aria-labelledby="addContactlistModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addContactlistModalLabel">Create New List</h5>
                <button type="button" class="close-model-btn" data-bs-dismiss="modal" aria-label="Close">
                    <i class="uil uil-multiply"></i>
                </button>
            </div>

            <form id="contactListForm" method="POST" action="{{ route('organiser.contact_lists.store') }}">
                @csrf
                <input type="hidden" name="_method" value="">

                <div class="modal-body">
                    <div class="model-content main-form">
                        <div class="form-group mt-30">
                            <label class="form-label">Name* <span class="text-danger">*</span></label>
                            <input class="form-control h_40" type="text" name="name" value="{{ old('name') }}" required>
                            @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mt-30">
                            <label class="form-label">Description / How you know them</label>
                            <textarea class="form-control" name="description" rows="4">{{ old('description') }}</textarea>
                            @error('description') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <!-- Placeholder for adding contacts -->
                      <div class="add-contact_area mt-30">
    <div class="row mb-3">

        <div class="col-md-4">
            <input type="email" class="form-control h_40 contact-email" name="email" placeholder="Email">
        </div>
        <div class="col-md-4">
            <input type="text" class="form-control h_40 contact-phone" name="phone" placeholder="Phone">
        </div>
    </div>

    <!-- Contact list table -->

</div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="co-main-btn min-width btn-hover h_40" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="main-btn min-width btn-hover h_40" id="submitBtn">Add Contact</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="wrapper wrapper-body">
    <div class="dashboard-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-main-title">
                        <h3><i class="fa-regular fa-address-card me-3"></i>Contact Lists</h3>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="main-card mt-5">
                        <div class="dashboard-wrap-content p-4">
                            <div class="d-md-flex flex-wrap align-items-center">
                                <div class="dashboard-date-wrap">
                                    <div class="form-group">
                                        <div class="relative-input position-relative">
                                            <input class="form-control h_40" type="text" placeholder="Search by name" value="">
                                            <i class="uil uil-search"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs ms-auto mt_r4">
                                    <button class="main-btn btn-hover h_40 w-100" data-bs-toggle="modal" data-bs-target="#addContactlistModal" id="createBtn">
                                      Add Contact
                                    </button>
                                </div>
                            </div>

                            <h5 class="mb-4 mt-5">Contact Lists ({{ $contacts->count() }})</h5>

                          @if($contacts->isNotEmpty())
                          @forelse ($contacts as $contact)
    <div class="main-card mt-4">
        <div class="contact-list coupon-active">
            <div class="top d-flex flex-wrap justify-content-between align-items-center p-4 border_bottom">
                <div class="icon-box coupon-icon-box-8606">
                    <span class="icon-big icon icon-purple">
                        <i class="fa-solid fa-users"></i>
                    </span>
                    <h5 class="font-18 mb-1 mt-1 f-weight-medium">{{ $contact->name }}</h5>
                    <p class="text-gray-50 m-0">{{ $contact->email }}</p>
                    <p class="text-gray-50 m-0">{{ $contact->phone ?? 'N/A' }}</p>
                    <p class="text-gray-50 m-0">{{ $contact->description ?? 'No description' }}</p>
                </div>
                <div class="d-flex align-items-center">
                    <div class="dropdown dropdown-default dropdown-text dropdown-icon-item">
                        <button class="option-btn-1" type="button" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <button type="button" class="dropdown-item edit-contact-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#addContactlistModal"
                                    data-id="{{ $contact->id }}"
                                    data-name="{{ $contact->name }}"
                                    data-email="{{ $contact->email }}"
                                    data-phone="{{ $contact->phone }}"
                                    data-description="{{ $contact->description ?? '' }}"
                                    data-action-url="{{ route('organiser.contact_lists.update', $contact->id) }}">
                                <i class="fa-solid fa-pen me-3"></i>Edit
                            </button>
                            <form action="{{ route('organiser.contact_lists.destroy', $contact->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dropdown-item text-danger"
                                        onclick="return confirm('Delete this contact?');">
                                    <i class="fa-solid fa-trash-can me-3"></i>Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bottom d-flex flex-wrap justify-content-between align-items-center p-4">
                <div class="icon-box">
                    <span class="icon"><i class="fa-solid fa-calendar-days"></i></span>
                    <p>Added on</p>
                    <h6 class="coupon-status">{{ $contact->created_at->format('M d, Y') }}</h6>
                </div>
            </div>
        </div>
    </div>
   @endforeach
@else
    <div class="alert alert-light text-center py-5 mt-4">
        <i class="uil uil-users fs-3 mb-3 d-block text-muted"></i>
        No contacts added yet.
    </div>
@endforelse




                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modalElement = document.getElementById('addContactlistModal');
    const form = document.getElementById('contactListForm');
    const title = modalElement.querySelector('.modal-title');
    const submitBtn = document.getElementById('submitBtn');
    const nameInput = form.querySelector('input[name="name"]');
    const descInput = form.querySelector('textarea[name="description"]');
    const methodInput = form.querySelector('input[name="_method"]');

    const bootstrapModal = new bootstrap.Modal(modalElement); // Bootstrap 5 modal instance

    // Create button (using data-bs-toggle) still works automatically

    // Edit buttons
   document.querySelectorAll('.edit-contact-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        // Edit mode
        title.textContent = 'Edit Contact';
        submitBtn.textContent = 'Update Contact';
        form.action = this.dataset.actionUrl;
        methodInput.value = 'PUT';           // or 'PATCH' — both work for update in Laravel
        nameInput.value = this.dataset.name || '';
        descInput.value = this.dataset.description || '';

        // Also fill email & phone (you have them in data- attributes)
        const emailInput = form.querySelector('input[name="email"]');
        const phoneInput = form.querySelector('input[name="phone"]');
        if (emailInput) emailInput.value = this.dataset.email || '';
        if (phoneInput) phoneInput.value = this.dataset.phone || '';

        bootstrapModal.show();
    });
});

    // Optional: Reset modal when hidden
    modalElement.addEventListener('hidden.bs.modal', function () {
        title.textContent = 'Create New List';
        submitBtn.textContent = 'Create List';
        form.action = '{{ route("organiser.contact_lists.store") }}';
        methodInput.value = '';
        nameInput.value = '';
        descInput.value = '';
    });
});

</script>

@endsection
