@extends('layouts.main')

@section('title', 'Result')

@section('content')
    <x-page-title />

    <x-page-section section="{{ $result->assessment->title }}">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-4">

                {{-- Action Buttons --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <a title="Export as PDF" href="#" class="btn btn-danger">
                            <i class="bi bi-file-earmark-pdf-fill me-1"></i>
                        </a>
                    </div>
                </div>

                {{-- Summary Info Grid --}}
                <div class="d-flex justify-content-center">
                    <div class="row row-cols-1 row-cols-md-2 g-4" style="max-width: 800px;">
                        <x-ui.info-item icon="award" color="info" label="Full Score" :value="$result->assessment->fullScore()" />
                        <x-ui.info-item icon="percent" color="info" label="Passing Percentage" :value="number_format($result->assessment->passing_percent, 2) . '%'" />
                        <x-ui.info-item icon="check-circle" color="success" label="Your Score" :value="$result->score" />
                        <x-ui.info-item icon="bar-chart" color="primary" label="Your Percentage" :value="number_format(($result->score / $result->assessment->fullScore()) * 100, 2) . '%'" />
                    </div>
                </div>

                {{-- Pass/Fail Message --}}
                <div class="mt-4">
                    <div class="card border-0 shadow-sm rounded-4 p-4 d-flex align-items-center text-center"
                        style="background-color: {{ $result->is_passed ? '#e6f4ea' : '#fdecea' }};">

                        <div class="mb-3">
                            <i class="bi {{ $result->is_passed ? 'bi-check-circle-fill text-success' : 'bi-x-circle-fill text-danger' }}"
                                style="font-size: 2.5rem;"></i>
                        </div>

                        <h5 class="fw-bold mb-2 text-{{ $result->is_passed ? 'success' : 'danger' }}">
                            {{ $result->is_passed ? 'Well Done!' : 'Don’t Give Up!' }}
                        </h5>

                        <p class="mb-0 text-muted">
                            {{ $result->is_passed
                                ? 'Congratulations! You passed the assessment with a great score. 🎉'
                                : 'Unfortunately, you didn’t pass this time. Review the material and try again!' }}
                        </p>
                    </div>
                </div>

                {{-- View Details Button --}}
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('profile.index') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-left"></i> Back to Profile
                    </a>
                    <a href="{{ route('results.participant.details', $result->id) }}" class="btn btn-success">
                        <i class="bi bi-eye-fill me-1"></i> View Details
                    </a>
                </div>

            </div>
        </div>
    </x-page-section>
@endsection
