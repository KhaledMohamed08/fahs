@extends('layouts.main')

@section('title', config('app.name') . ' | Login')

@section('content')
    <x-page-title />

    <div class="container py-5">
        <div class="row align-items-center justify-content-between">
            <!-- Login Form -->
            <div class="col-lg-5">
                <div class="text-center mb-4">
                    <h2 class="fw-bold">Welcome Back!</h2>
                    <p class="text-muted">Login to your account</p>
                </div>

                <form action="#" method="POST">
                    @csrf

                    <!-- Email or Phone -->
                    <div class="form-floating mb-3">
                        <input type="text" name="data" id="data" class="form-control" placeholder="Email or Phone"
                            required>
                        <label for="data">Email or Phone</label>
                    </div>

                    <!-- Password -->
                    <div class="position-relative form-floating mb-3">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password"
                            required>
                        <label for="password">Password</label>
                        <i class="bi bi-eye password-toggle position-absolute end-0 top-50 translate-middle-y me-4"
                            role="button" style="cursor: pointer;"></i>
                    </div>

                    <!-- Remember Me -->
                    <div class="form-check mb-4">
                        <input type="checkbox" name="remember" id="remember" class="form-check-input">
                        <label for="remember" class="form-check-label">Remember Me</label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary w-100 py-2">Login</button>

                    <!-- Social Login -->
                    {{-- <div class="text-center mt-4">
                        <p class="text-muted mb-2">Or login with</p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="#" class="btn btn-danger" title="Login with Google">
                                <i class="bi bi-google"></i>
                            </a>
                            <a href="#" class="btn btn-primary" title="Login with Facebook">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="#" class="btn btn-dark" title="Login with GitHub">
                                <i class="bi bi-github"></i>
                            </a>
                        </div>
                    </div> --}}


                    <!-- Extra Links -->
                    <div class="text-center mt-3 d-flex flex-column gap-2">
                        <small>
                            Forgot your password?
                            <a href="#">Reset here</a>
                        </small>
                        <small>
                            Don’t have an account?
                            <a href="{{ route('page.register') }}">Register</a>
                        </small>
                    </div>
                </form>
            </div>

            <!-- Illustration -->
            <div class="col-lg-6 d-none d-lg-block">
                <img src="{{ asset('assets/img/features-illustration-3.webp') }}" alt="Login Illustration" class="img-fluid">
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggle = document.querySelector('.password-toggle');
            const passwordInput = document.getElementById('password');

            toggle.addEventListener('click', () => {
                const isPassword = passwordInput.type === 'password';
                passwordInput.type = isPassword ? 'text' : 'password';
                toggle.classList.toggle('bi-eye');
                toggle.classList.toggle('bi-eye-slash');
            });
        });
    </script>
@endpush
