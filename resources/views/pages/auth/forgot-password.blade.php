@extends('layouts.main')

@section('title', config('app.name') . ' | Forgot Password')

@section('content')
    <x-page-title />

    <div class="container py-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-5">
                <div class="text-center mb-4">
                    <h2 class="fw-bold">Forgot Password?</h2>
                    <p class="text-muted">Enter your email to reset your password</p>
                </div>

                <form action="{{ route('password.email') }}" method="POST">
                    @csrf

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

                    <button type="submit" class="btn btn-primary w-100 py-2">
                        Send Reset Link
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
