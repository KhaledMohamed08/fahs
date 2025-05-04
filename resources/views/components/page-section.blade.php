@props([
    'section' => '',
    'description' => '',
])
{{-- Starter Section Section --}}
<section id="starter-section" class="starter-section section">

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

    <div class="container" data-aos="fade-up">
        {{ $slot }}
    </div>

</section>
{{-- /Starter Section Section --}}
