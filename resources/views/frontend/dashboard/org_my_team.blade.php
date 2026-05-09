@extends('frontend.dashboard.master')

@section('title', 'My Team')

@section('content')
<!-- Bootstrap JS (with Popper for modals) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Invite Modal -->
<div class="modal fade" id="inviteTeamModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('team.invite') }}">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Invite a Team Member</h5>
                    <button type="button" class="close-model-btn" data-bs-dismiss="modal"><i class="uil uil-multiply"></i></button>
                </div>

                <div class="modal-body">
                    <div class="model-content main-form">
                        <div class="form-group mt-30">
                            <label class="form-label">Email address *</label>
                            <input name="email" class="form-control h_40" type="email" placeholder="Enter email" required>
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group mt-30">
                            <label class="form-label">Role *</label>
                            <select name="role" class="selectpicker" required>
                                @foreach(\Spatie\Permission\Models\Role::all() as $role)
                                    @if($role->name !== 'account_owner') <!-- skip account_owner -->
                                        <option value="{{ $role->name }}">{{ ucwords(str_replace('_', ' ', $role->name)) }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mt-30">
                            <div class="d-flex align-items-start">
                                <label class="btn-switch m-0 me-3">
                                    <input type="checkbox" name="send_emails" value="1">
                                    <span class="checkbox-slider"></span>
                                </label>
                                <div class="d-flex flex-column">
                                    <label class="color-black fw-bold mb-0">Send system emails to this team member</label>
                                    <p class="mt-2 fs-14 d-block mb-0">System emails provide information about events created, as well as updates to the system.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="co-main-btn min-width btn-hover h_40" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="main-btn min-width btn-hover h_40">Invite</button>
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
                        <h3><i class="fa-solid fa-user-group me-3"></i>Team Members</h3>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="conversion-setup">
                        <div class="main-card mt-5">
                            <div class="dashboard-wrap-content p-4">
                                <div class="d-md-flex flex-wrap align-items-center">
                                    <div class="nav custom2-tabs btn-group" role="tablist">
                                        <button class="tab-link ms-0 {{ $tab === 'overview' ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#overview-tab">Overview</button>
                                        <button class="tab-link {{ $tab === 'role' ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#role-tab">Role</button>
                                    </div>
                                    <div class="rs ms-auto mt_r4">
                                        <button class="main-btn btn-hover h_40 w-100" data-bs-toggle="modal" data-bs-target="#inviteTeamModal">Invite a Team Member</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-content">
                            <div class="tab-pane fade {{ $tab === 'overview' ? 'active show' : '' }}" id="overview-tab">
                                <div class="table-card mt-4">
                                    <div class="main-table">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Role</th>
                                                        <th>Last Login</th>
                                                        <th>2FA Enabled</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($teamMembers as $member)
                                                        <tr>
                                                            <td>{{ $member->name }}</td>
                                                            <td>{{ $member->email }}</td>
                                                            <td>{{ ucwords(str_replace('_', ' ', $member->role)) }}</td>
                                                            <td>{{ $member->last_login }}</td>
                                                            <td>{{ $member->twofa }}</td>
                                                            <td>
                                                                @if($member->can_delete)
                                                                    <form action="{{ route('team.remove', $member->id) }}" method="POST" style="display:inline;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="action-btn" onclick="return confirm('Remove this member?')">
                                                                            <i class="fa-solid fa-trash-can"></i>
                                                                        </button>
                                                                    </form>
                                                                @else
                                                                    <span class="action-btn disabled"><i class="fa-solid fa-lock"></i></span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="6" class="text-center py-4">No team members yet.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade {{ $tab === 'role' ? 'active show' : '' }}" id="role-tab">
                                <div class="role-slider-content mt-4">
                                    <div class="owl-carousel role-slider owl-theme">
                                        <!-- Keep your static role cards or generate dynamically if needed -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
