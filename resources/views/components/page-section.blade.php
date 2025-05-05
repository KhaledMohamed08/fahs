@props([
    'section' => '',
    'description' => '',
    'class' => '',
    'id' => 'starter-section',
    'containerClass' => 'container',
    'containerId' => '',
])

{{-- Starter Section --}}
<section id="{{ $id }}" class="starter-section section {{ $class }}">

    {{-- Section Title --}}
    @if (!empty($section))
        <div class="container section-title" data-aos="fade-up">
            <h2>{{ $section }}</h2>
            @if (!empty($description))
                <p>{{ $description }}</p>
            @endif
        </div>
    @endif
    {{-- End Section Title --}}

    <x-container class="{{ $containerClass }}" id="{{ $containerId }}">

        {{ $slot }}

    </x-container>

</section>
{{-- Starter Section Section --}}
