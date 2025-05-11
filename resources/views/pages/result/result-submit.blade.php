@extends('layouts.empty')
@section('title', 'Result | Submit')
@section('body')
    <div class="min-vh-100 d-flex justify-content-center align-items-start bg-light pt-5">
        <div class="card shadow-lg p-4 border-0 rounded-4 text-center" style="max-width: 500px; width: 100%;">
            <div class="card-body">
                <h4 class="mb-3 text-success fw-bold">Assessment Submitted</h4>
                <p class="text-muted h6">We’ve received your submission. Thank you for your participation.</p>
                @if ($result->status == 'done')
                    <h5 class="mb-4 text-muted">Your result has been <span class="text-success fw-bold">finalized</span>.</h5>
                    @if ($result->assessment->isPassed($result->score))
                        <h5 class="mb-4 text-muted">Congratulations! You have <span
                                class="text-success fw-bold">passed</span>.</h5>
                        <h5 class="mb-4 text-muted">Final Score: <span
                                class="fw-bold text-success">{{ $result->score }}</span> From
                            <span class="fw-bold">{{ $result->assessment->fullScore() }}</span>
                        </h5>
                    @else
                        <h5 class="mb-4 text-muted">Unfortunately, you have <span class="text-danger fw-bold">not
                                passed</span>.</h5>
                        <h5 class="mb-4 text-muted">Final Score: <span
                                class="fw-bold text-danger">{{ $result->score }}</span> From
                            <span class="fw-bold">{{ $result->assessment->fullScore() }}</span>
                        </h5>
                    @endif
                @else
                    <h5 class="mb-4 text-muted">Your result is currently <span class="text-danger fw-bold">pending
                            review</span>.</h5>
                @endif

                <button class="btn btn-success mt-3" onclick="window.close();">
                    Close Assessment Window
                </button>

            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        window.onbeforeunload = function() {
            window.close();
        };
    </script>
@endpush
