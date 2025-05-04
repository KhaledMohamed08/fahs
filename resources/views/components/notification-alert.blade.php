@props(['errors' => $errors])

@php
    $flashTypes = [
        'success' => 'success',
        'error' => 'danger',
        'fail' => 'danger',
        'warning' => 'warning',
        'info' => 'info',
    ];
@endphp

{{-- Validation Errors --}}
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show position-fixed start-50 translate-middle-x z-1000 shadow w-auto w-sm-75 w-md-50 text-center"
        style="top: 80px;">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <ul class="mb-0 ps-4 text-start">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- Flash Messages --}}
@foreach ($flashTypes as $key => $type)
    @if (session()->has($key))
        <div class="alert alert-{{ $type }} alert-dismissible fade show position-fixed start-50 translate-middle-x z-1000 shadow w-auto w-sm-75 w-md-50 text-center"
            style="top: 80px;">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            {{ session($key) }}
        </div>
    @endif
@endforeach
