@props([
    'icon',
    'color' => 'primary',
    'label',
    'value',
    'valueColor' => 'muted',
])

<div class="col">
    <div class="d-flex align-items-start">
        <i class="bi bi-{{ $icon }} text-{{ $color }} fs-4 me-3"></i>
        <div>
            <h6 class="mb-1 fw-bold">{{ $label }}</h6>
            <p class="text-{{ $valueColor }} mb-0">{{ $value }}</p>
        </div>
    </div>
</div>
