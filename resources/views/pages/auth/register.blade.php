@extends('layouts.main')

@section('title', config('app.name') . ' | Register')

@section('content')
    <x-page-title />

    <div class="container py-5">

        <div class="row align-items-center justify-content-between">

            <!-- Illustration -->
            <div class="col-lg-6 d-none d-lg-block">
                <img src="{{ asset('assets/img/features-illustration-1.webp') }}" alt="Register Illustration" class="img-fluid">
            </div>

            <!-- Register Form -->
            <div class="col-lg-5">
                <div class="text-center mb-4">
                    <h2 class="fw-bold">Create Account</h2>
                    <p class="text-muted">Fill in your details to register</p>
                </div>

                <form action="{{ route('register') }}" method="POST" class="needs-validation" novalidate>
                    @csrf

                    <!-- Name -->
                    <div class="form-floating mb-3">
                        <input type="text" name="name" id="name" class="form-control" placeholder="Full Name"
                            required>
                        <label for="name">Full Name*</label>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="form-floating mb-3">
                        <input type="text" name="phone" id="phone" class="form-control" placeholder="+201020304050"
                            required>
                        <label for="phone">Phone Number*</label>
                        @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-floating mb-3">
                        <input type="email" name="email" id="email" class="form-control"
                            placeholder="name@example.com" required>
                        <label for="email">Email Address*</label>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-floating mb-3">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password"
                            required>
                        <i class="bi bi-eye position-absolute end-0 top-50 translate-middle-y me-4" style="cursor: pointer;"
                            onclick="togglePassword('password', this)"></i>
                        <label for="password">Password*</label>
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-floating mb-4">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                            placeholder="Confirm Password" required>
                        <i class="bi bi-eye position-absolute end-0 top-50 translate-middle-y me-4" style="cursor: pointer;"
                            onclick="togglePassword('password_confirmation', this)"></i>
                        <label for="password_confirmation">Confirm Password*</label>
                    </div>

                    <!-- User Type -->
                    <div class="mb-4">
                        <label class="form-label d-block">Account Type*</label>
                        <div class="d-flex align-items-center justify-content-around">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type" id="participant"
                                    value="participant" checked required>
                                <label class="form-check-label" for="participant">
                                    <i class="bi bi-mortarboard me-1"></i> Participant
                                </label>
                                <div class="form-text">For users taking quizzes.</div>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type" id="foundation"
                                    value="foundation" required>
                                <label class="form-check-label" for="foundation">
                                    <i class="bi bi-building me-1"></i> Foundation
                                </label>
                                <div class="form-text">For quiz creators.</div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary w-100 py-2">Register</button>

                    <!-- Already Registered -->
                    <div class="text-center mt-3">
                        <small>
                            Already have an account?
                            <a href="{{ route('page.login') }}">Login</a>
                        </small>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function togglePassword(inputId, iconElement) {
            const input = document.getElementById(inputId);
            if (input.type === 'password') {
                input.type = 'text';
                iconElement.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                input.type = 'password';
                iconElement.classList.replace('bi-eye-slash', 'bi-eye');
            }
        }
    </script>
@endpush
