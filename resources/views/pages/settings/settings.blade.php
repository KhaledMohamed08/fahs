@extends('layouts.main')
@section('title', 'Settings')

@section('content')
    <x-page-title />

    <x-page-section>
        <div class="d-flex align-items-start justify-content-between">
            <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <button class="nav-link active" id="v-pills-update-info-tab" data-bs-toggle="pill"
                    data-bs-target="#v-pills-update-info" type="button" role="tab" aria-controls="v-pills-update-info"
                    aria-selected="true">Update Your Info</button>
                <button class="nav-link" id="v-pills-reset-password-tab" data-bs-toggle="pill"
                    data-bs-target="#v-pills-reset-password" type="button" role="tab"
                    aria-controls="v-pills-reset-password" aria-selected="false">Reset Password</button>
                <button class="nav-link" id="v-pills-delete-account-tab" data-bs-toggle="pill"
                    data-bs-target="#v-pills-delete-account" type="button" role="tab"
                    aria-controls="v-pills-delete-account" aria-selected="false">Delete Account</button>
            </div>
            <div class="d-flex tab-content w-75" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-update-info" role="tabpanel"
                    aria-labelledby="v-pills-update-info-tab" tabindex="0">
                    <h3 class="text-center mb-3">Update Your Account Info</h3>
                    <form class="row g-3" action="{{ route('settings.update.info') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="col-12">
                            <label for="name" class="form-label">Full Name*</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ auth()->user()->name }}" required>
                        </div>
                        <div class="col-12">
                            <label for="phone" class="form-label">Phone Number*</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                value="{{ auth()->user()->phone }}" required>
                        </div>
                        <div class="col-12">
                            <label for="email" class="form-label">Email Address*</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ auth()->user()->email }}" required>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Update Your Info</button>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="v-pills-reset-password" role="tabpanel"
                    aria-labelledby="v-pills-reset-password-tab" tabindex="0">
                    <h3 class="text-center mb-3">Reset Your Password</h3>
                    <form class="row g-3" action="{{ route('settings.reset.password') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="col-12">
                            <label for="old-password" class="form-label">Old Password*</label>
                            <input type="password" class="form-control" id="old-password" name="old_password" required>
                        </div>
                        <div class="col-12">
                            <label for="new-password" class="form-label">New Password*</label>
                            <input type="password" class="form-control" id="new-password" name="new_password" required>
                        </div>
                        <div class="col-12">
                            <label for="new-password-confirmation" class="form-label">Confirm New Password*</label>
                            <input type="password" class="form-control" id="new-password-confirmation"
                                name="new_password_confirmation" required>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Resete Your Password</button>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade d-flex flex-column justify-content-center w-75" id="v-pills-delete-account"
                    role="tabpanel" aria-labelledby="v-pills-delete-account-tab" tabindex="0">
                    <!-- Trigger Section -->
                    <h3 class="text-center mb-3">Delete Your Account</h3>

                    <p class="text-center text-muted mb-4">
                        Hey {{ auth()->user()->name }}, we're truly sorry you're thinking about leaving.
                        This isn’t just a button—it’s goodbye to everything you've built and shared with us.
                        Your account, preferences, and all your data will be gone forever.
                        If there’s anything we can do to make things better, we’re here for you.
                        Please take a moment to reconsider—your journey with us still matters.
                    </p>

                    <div class="col-12 text-center">
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#confirmDeleteModal">
                            Delete My Account
                        </button>
                    </div>

                    <!-- Confirmation Modal -->
                    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <form method="POST" action="{{ route('settings.delete.account') }}">
                                @csrf
                                @method('DELETE')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmDeleteLabel">Confirm Account Deletion</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <p class="text-muted">
                                            Hey {{ auth()->user()->name }}, this decision is permanent.
                                            Deleting your account will erase all your data and cannot be undone.
                                            If you're sure, please confirm by entering your password below.
                                        </p>

                                        <div class="mb-3">
                                            <label for="password" class="form-label">Your Password</label>
                                            <input type="password" name="password" id="password" class="form-control"
                                                required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                                            <input type="password" name="password_confirmation"
                                                id="password_confirmation" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger">Yes, Delete My Account</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </x-page-section>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabKey = 'activeTab';

            // Restore active tab from localStorage
            const lastTab = localStorage.getItem(tabKey);
            if (lastTab) {
                const trigger = document.querySelector(`[data-bs-target="${lastTab}"]`);
                if (trigger) {
                    const tab = new bootstrap.Tab(trigger);
                    tab.show();
                }
            }

            // Save active tab to localStorage
            const tabButtons = document.querySelectorAll('#v-pills-tab button[data-bs-toggle="pill"]');
            tabButtons.forEach(button => {
                button.addEventListener('shown.bs.tab', function(event) {
                    localStorage.setItem(tabKey, event.target.getAttribute('data-bs-target'));
                });
            });
        });
    </script>
@endpush
