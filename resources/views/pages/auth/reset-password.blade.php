@extends('layouts.main')

@section('title', config('app.name') . ' | Reset Password')

@section('content')
    <x-page-title />

    <div class="container py-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-5">
                <div class="text-center mb-4">
                    <h2 class="fw-bold">Reset Password</h2>
                    <p class="text-muted">Enter your email and new password</p>
                </div>

                <form action="{{ route('password.update') }}" method="POST">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-floating mb-3">
                        <input 
                            type="email" 
                            name="email" 
                            id="email" 
                            class="form-control" 
                            placeholder="Email" 
                            required
                        >
                        <label for="email">Email</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            class="form-control" 
                            placeholder="New Password" 
                            required
                        >
                        <label for="password">New Password</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            id="password-confirmation" 
                            class="form-control" 
                            placeholder="Confirm Password" 
                            required
                        >
                        <label for="password-confirmation">Confirm New Password</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2">
                        Reset Password
                    </button>

                    <div class="text-center mt-3">
                        <small>
                            Remembered your password?
                            <a href="{{ route('page.login') }}">Login</a>
                        </small>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
