@props([
    'title' => '',
    'breadcrumbs' => true,
    'class' => '',
])
{{-- Page Title --}}
<div class="page-title light-background {{ $class }}">
    <x-notification-alert />

    @if (!empty($title))
        <div class="container">
            <h1>{{ $title }}</h1>
            @if ($breadcrumbs)
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li class="current">{{ $title }}</li>
                    </ol>
                </nav>
            @endif
        </div>
    @endif
</div>


{{-- End Page Title --}}
@empty($title)
    @push('styles')
        <style>
            .page-title {
                padding: 40px 0 80px 0;
            }
        </style>
    @endpush
@endempty
