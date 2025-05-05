@props([
    'class' => 'container',
    'id' => '',
])

<div class="{{ $class }}" id="{{ $id }}" data-aos="fade-up">
    {{ $slot }}
</div>