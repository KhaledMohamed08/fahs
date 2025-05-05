@extends('layouts.main')
@section('title', 'Create Assessment')
@section('content')
    <x-page-title />

    <x-page-section section="Create New Assessment">
        <form method="POST" action="{{ route('assessments.store') }}">
            @csrf

            <ul class="nav nav-tabs justify-content-center mb-3" id="assessmentTabs" role="tablist">
                <li class="nav-item flex-fill text-center" role="presentation">
                    <button class="nav-link active w-100" id="assessment-tab" data-bs-toggle="tab"
                        data-bs-target="#assessment-tab-pane" type="button" role="tab"
                        aria-controls="assessment-tab-pane" aria-selected="true">
                        Assessment Info
                    </button>
                </li>
                <li class="nav-item flex-fill text-center" role="presentation">
                    <button class="nav-link w-100" id="questions-tab" data-bs-toggle="tab"
                        data-bs-target="#questions-tab-pane" type="button" role="tab"
                        aria-controls="questions-tab-pane" aria-selected="false">
                        Questions
                    </button>
                </li>
            </ul>

            <div class="tab-content border rounded p-4 bg-light" id="assessmentTabContent">
                {{-- Assessment Info Tab --}}
                <div class="tab-pane fade show active" id="assessment-tab-pane" role="tabpanel"
                    aria-labelledby="assessment-tab" tabindex="0">

                    <div class="row">
                        {{-- Assessment Title --}}
                        <div class="col-md-6 mb-3">
                            <label for="title" class="form-label">Assessment Title*</label>
                            <input type="text" name="title" id="title" class="form-control"
                                value="{{ old('title') }}" required>
                        </div>

                        {{-- Category --}}
                        <div class="col-md-6 mb-3">
                            <label for="category_id" class="form-label">Category*</label>
                            <select name="category_id" id="category_id" class="form-select" required>
                                <option value="">Select category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Description --}}
                        <div class="col-12 mb-3">
                            <label for="description" class="form-label">Assessment Description <span
                                    class="text-muted">(optional)</span></label>
                            <textarea name="description" id="description" class="form-control" rows="4" style="resize: none">{{ old('description') }}</textarea>
                        </div>

                        {{-- Difficulty Level --}}
                        <div class="col-md-4 mb-3">
                            <label for="difficulty_level" class="form-label">Difficulty Level*</label>
                            <select name="difficulty_level" id="difficulty_level" class="form-select" required>
                                @foreach (App\Enums\DifficultyLevelEnum::cases() as $level)
                                    <option value="{{ $level->value }}"
                                        {{ old('difficulty_level') == $level->value ? 'selected' : '' }}>
                                        {{ $level->label() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Passing Percentage --}}
                        <div class="col-md-4 mb-3">
                            <label for="passing_percent" class="form-label">Passing Percentage (%)</label>
                            <input type="number" name="passing_percent" id="passing_percent" min="50"
                                class="form-control [&::-webkit-inner-spin-button]:appearance-none"
                                value="{{ old('passing_percent', 50) }}">
                        </div>

                        {{-- Duration --}}
                        <div class="col-md-4 mb-3">
                            <label for="duration_minutes" class="form-label">Duration (minutes)</label>
                            <input type="number" name="duration_minutes" id="duration_minutes" min="0"
                                class="form-control [&::-webkit-inner-spin-button]:appearance-none"
                                value="{{ old('duration_minutes', 0) }}">
                            <small class="text-muted">Set 0 for no time limit.</small>
                        </div>

                        <div class="row mb-3">
                            {{-- Private Assessment --}}
                            <div class="col-md-6 col-sm-12 mb-2 form-check">
                                <input type="checkbox" name="access" value="private" id="access"
                                    class="form-check-input" {{ old('access') === 'private' ? 'checked' : '' }}>
                                <label for="access" class="form-check-label fw-semibold">Private Assessment</label>
                                <div class="form-text">Only invited participants can access.</div>
                            </div>

                            {{-- Auto Grading --}}
                            <div class="col-md-6 col-sm-12 mb-2 form-check">
                                <input type="checkbox" name="auto_grade" value="1" id="auto_grade"
                                    class="form-check-input" {{ old('auto_grade', true) ? 'checked' : '' }}>
                                <label for="auto_grade" class="form-check-label fw-semibold">Enable Auto Grading</label>
                                <div class="form-text">If the assessment includes free text questions, manual confirmation
                                    may still be required.</div>
                            </div>
                        </div>


                    </div>
                </div>

                {{-- Questions Tab --}}
                <div class="tab-pane fade" id="questions-tab-pane" role="tabpanel" aria-labelledby="questions-tab"
                    tabindex="0">
                    <div id="questions-container">
                        <!-- Initial question will be added by JS -->
                    </div>

                    {{-- Add More Questions --}}
                    <div class="text-start">
                        <button id="add-question-btn" type="button" class="btn btn-outline-secondary btn-sm"
                            onclick="addQuestion()" disabled>
                            Add Another Question
                        </button>
                        <div class="text-muted mt-2">
                            You must fill in all question data to add a new question.
                        </div>
                    </div>


                </div>
            </div>

            <div class="mt-4 text-center">
                <button type="submit" class="btn btn-primary">Create an Assessment</button>
            </div>
        </form>
    </x-page-section>


@endsection
@push('scripts')
    @vite(['resources/assets/js/create-assessment.js'])
@endpush
