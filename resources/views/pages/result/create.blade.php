@php
    if (!session()->has('assessment_start')) {
        session(['assessment_start' => true]);
    }
    if ($assessment->duration_minutes > 0) {
        $timezone = 'Africa/Cairo';
        $now = now($timezone);

        if (!session()->has("assessment_start_time_{$assessment->id}")) {
            session(["assessment_start_time_{$assessment->id}" => $now->toDateTimeString()]);
        }

        $startTime = \Carbon\Carbon::parse(session("assessment_start_time_{$assessment->id}"), $timezone);
        $endTime = $startTime->copy()->addMinutes($assessment->duration_minutes);
        $remainingSeconds = (int) max(0, $now->diffInSeconds($endTime));
    }
@endphp
@extends('layouts.empty')
@section('title', 'Solve Assessment')
@php
    $questions = $assessment->questions;
@endphp
@section('body')
    <x-page-title />

    <x-page-section containerClass="container-fluid">
        <div class="py-5">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    @if ($assessment->duration_minutes > 0)
                        <div class="d-flex flex-column justify-content-start align-items-end mb-2">
                            <h5 class="fw-semibold text-muted mb-0">Time Remaining</h5>
                            <div id="timer" class="fs-5 fw-bold text-danger"></div>
                        </div>
                    @endif

                    <div class="progress mb-4" style="height: 8px;">
                        <div id="progressBar" class="progress-bar" style="width: 0%; background-color:rgb(45, 70, 94)">
                        </div>
                    </div>
                    <form id="assessmentForm" action="{{ route('results.store') }}" method="POST">
                        @csrf
                        <input hidden name="assessment_id" value="{{ $assessment->id }}">
                        <div id="assessment-steps">
                            @foreach ($questions as $index => $question)
                                <div class="card shadow-lg step p-4 mb-4 border-0 rounded-4"
                                    style="display: {{ $index === 0 ? 'block' : 'none' }};">
                                    <div class="card-body">
                                        <h5 class="mb-3 fw-semibold text-muted">Question {{ $index + 1 }} of
                                            {{ $questions->count() }}</h5>
                                        <h4 class="mb-4">{{ $question->title }}</h4>

                                        @if ($question->type === 'multiple_choice')
                                            @foreach ($question->options as $option)
                                                <input type="radio" class="btn-check" name="answers[{{ $question->id }}]"
                                                    id="q{{ $question->id }}_{{ Str::slug($option['title']) }}"
                                                    value="{{ $option['title'] }}" autocomplete="off">

                                                <label class="option-label"
                                                    for="q{{ $question->id }}_{{ Str::slug($option['title']) }}">
                                                    {{ chr(64 + $loop->iteration) . '. ' . $option['title'] }}
                                                </label>
                                            @endforeach
                                        @elseif ($question->type === 'true_false')
                                            <div class="btn-group w-100" role="group" aria-label="True or False">
                                                <div class="d-flex justify-content-start gap-3 align-items-center">
                                                    <div>
                                                        <input type="radio" class="btn-check"
                                                            name="answers[{{ $question->id }}]"
                                                            id="true_{{ $question->id }}" value="1"
                                                            autocomplete="off">
                                                        <label class="btn btn-outline-success px-4 py-2"
                                                            for="true_{{ $question->id }}">
                                                            <i class="bi bi-check-lg"></i> True
                                                        </label>
                                                    </div>
                                                    <div>
                                                        <input type="radio" class="btn-check"
                                                            name="answers[{{ $question->id }}]"
                                                            id="false_{{ $question->id }}" value="0"
                                                            autocomplete="off">
                                                        <label class="btn btn-outline-danger px-4 py-2"
                                                            for="false_{{ $question->id }}">
                                                            <i class="bi bi-x-lg"></i> False
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif ($question->type === 'free_text')
                                            <input id="answer_{{ $question->id }}" type="hidden"
                                                name="answers[{{ $question->id }}]">
                                            <trix-editor input="answer_{{ $question->id }}"
                                                style="min-height: 300px;"></trix-editor>
                                        @endif

                                        <div class="mt-4 d-flex justify-content-end gap-3">
                                            @if ($index > 0)
                                                <button type="button" class="btn btn-outline-secondary prev-btn">
                                                    ← Previous
                                                </button>
                                            @endif

                                            @if ($index < $questions->count() - 1)
                                                <button type="button" class="btn btn-primary next-btn">
                                                    Next →
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-success" id="openConfirmModal">Submit
                                                    Assessment</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Submit Confirmation Modal -->
        <div class="modal fade" id="confirmSubmitModal" tabindex="-1" aria-labelledby="confirmSubmitModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-start">
                <div class="modal-content rounded-4">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmSubmitModalLabel">Confirm Submission</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body fs-6 text-muted">
                        <p>You're about to submit the assessment.</p>
                        <p id="questionsStatus" class="fw-semibold text-dark"></p> <!-- This gets updated dynamically -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-success" id="confirmSubmitBtn">Yes, Submit</button>
                    </div>
                </div>
            </div>
        </div>


    </x-page-section>
@endsection

@push('styles')
    @vite(['resources/assets/css/create-result.css'])
    {{-- rix Editor CSS --}}
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
@endpush
@push('scripts')
    @vite(['resources/assets/js/create-result.js'])
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const timerEl = document.getElementById('timer');
            if (timerEl !== null) {
                timerEl.dataset.remainingSeconds = {{ $remainingSeconds ?? 0 }};
            }
        });
    </script>
    {{-- Trix Editor JS --}}
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>
@endpush
