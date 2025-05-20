@extends('layouts.main')

@section('title', 'Verify Email Address')

@section('content')
    <x-page-title />

    <x-page-section class="call-to-action section">
        <div class="row content justify-content-center align-items-center position-relative">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="display-4 mb-4">You Must Verify Your Email To Access This Page.</h2>
                {{-- <p class="mb-4">Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;
                    Donec velit neque, auctor sit amet aliquam vel</p> --}}
                    <form action="{{ route('verification.send') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-cta">Request Another Verification Email</button>
                    </form>
            </div>
        </div>
    </x-page-section>
@endsection
@push('styles')
    <style>
        .call-to-action .container {
            background-color: #f3f9ff;
            color: var(--heading-color);
        }

        .call-to-action .content h2,
        .call-to-action .content p,
        .call-to-action .btn-cta,
        .call-to-action .btn-cta:hover {
            color: var(--heading-color);
        }
        .call-to-action .btn-cta {
            border: 2px solid var(--heading-color);
        }
    </style>
@endpush
