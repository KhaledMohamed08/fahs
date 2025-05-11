@extends('layouts.main')
@section('title', 'Assessmrnt')
@section('content')
    <x-page-title />

    <x-page-section section="{{ $assessment->title }}" containerClass="container-fluid">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-4">
                {{-- Action Buttons --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="d-flex justify-content-start align-items-center">
                        <a title="Export as PDF" href="#" class="btn btn-danger me-2">
                            <i class="bi bi-file-earmark-pdf-fill me-1"></i>
                        </a>

                        <a title="Export as Word" href="#" class="btn btn-primary me-2">
                            <i class="bi bi-file-earmark-word-fill me-1"></i>
                        </a>

                        <a title="Export as Excel" href="#" class="btn btn-success me-2">
                            <i class="bi bi-file-earmark-spreadsheet"></i>
                        </a>
                    </div>
                    <div class="d-flex justify-content-start align-items-center">
                        <a href="#" class="btn btn-warning me-2" data-bs-toggle="modal"
                            data-bs-target="#editAssessmentModal">
                            <i class="bi bi-pencil-square me-1"></i> Edit Assessment
                        </a>
                    </div>
                </div>
                {{-- Description --}}
                <div class="mb-4">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-info-circle-fill text-primary fs-4 me-3"></i>
                        <div>
                            <h6 class="mb-1 fw-bold">Description</h6>
                            <p class="text-muted mb-0">{{ $assessment->description ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Grid Information --}}
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">

                    <x-ui.info-item icon="qr-code" color="info" label="Code" :value="$assessment->code" />
                    <x-ui.info-item icon="tag" color="secondary" label="Category" :value="$assessment->category->title" />
                    <x-ui.info-item icon="clock-fill" color="warning" label="Duration" :value="$assessment->duration_minutes > 0
                        ? $assessment->duration_minutes . ' minutes'
                        : 'Unlimited'" />
                    <x-ui.info-item icon="list-ol" color="success" label="Total Questions" :value="$assessment->questions->count()" />
                    <x-ui.info-item icon="percent" color="danger" label="Passing Percentage" :value="$assessment->passing_percent . '%'" />
                    <x-ui.info-item icon="speedometer2" color="dark" label="Difficulty Level" :value="App\Enums\DifficultyLevelEnum::from($assessment->difficulty_level)->label()"
                        :valueColor="App\Enums\DifficultyLevelEnum::from($assessment->difficulty_level)->badge()" />
                    <x-ui.info-item icon="robot" color="muted" label="Auto Grade" :value="$assessment->auto_grade ? 'Enabled' : 'Disabled'" :valueColor="$assessment->auto_grade ? 'success' : 'danger'" />
                    <x-ui.info-item icon="lock-fill" color="warning" label="Access" :value="$assessment->access" :valueColor="$assessment->access == 'public' ? 'primary' : 'danger'" />
                    <x-ui.info-item icon="trophy-fill" color="info" label="Full Score" :value="$assessment->fullScore()" />
                    <x-ui.info-item icon="power" color="success" label="Is Active" :value="$assessment->is_active ? 'Active' : 'Inactive'"
                        :valueColor="$assessment->is_active ? 'success' : 'danger'" />
                    <x-ui.info-item icon="calendar-check" color="secondary" label="Created At" :value="$assessment->created_at->format('Y-m-d H:i')" />
                    <x-ui.info-item icon="arrow-repeat" color="secondary" label="Last Update" :value="$assessment->updated_at->format('Y-m-d H:i')" />

                </div>

                <div class="d-flex justify-content-end mb-4">
                    <a href="{{ route('questions.index', $assessment->id) }}" class="btn btn-primary">
                        <i class="bi bi-eye-fill me-1"></i> View Questions
                    </a>
                </div>
            </div>
        </div>

        <!-- Edit Assessment Modal -->
        <div class="modal fade" id="editAssessmentModal" tabindex="-1" aria-labelledby="editAssessmentModalLabel"
            aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editAssessmentModalLabel">Edit Assessment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editAssessmentForm" action="{{ route('assessments.update', $assessment->id) }}"
                            method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Row for Title, Category, and Description -->
                            <div class="row g-4">
                                <!-- Title and Category in one column -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="assessmentTitle" class="form-label">Assessment Title</label>
                                        <input type="text" class="form-control" id="assessmentTitle" name="title"
                                            value="{{ $assessment->title }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="assessmentCategory" class="form-label">Category</label>
                                        <select class="form-select" id="assessmentCategory" name="category_id">
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ $assessment->category_id == $category->id ? 'selected' : '' }}>
                                                    {{ $category->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Description in second column -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="assessmentDescription" class="form-label">Description</label>
                                        <textarea class="form-control" id="assessmentDescription" name="description" rows="5">{{ $assessment->description }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Remaining Fields (Duration, Passing Percentage, Difficulty, etc.) -->
                            <div class="row g-4">
                                <!-- Duration -->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="assessmentDuration" class="form-label">Duration (minutes)</label>
                                        <input type="number" class="form-control" id="assessmentDuration"
                                            name="duration_minutes" value="{{ $assessment->duration_minutes }}"
                                            min="0">
                                    </div>
                                </div>

                                <!-- Passing Percentage -->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="assessmentPassingPercent" class="form-label">Passing
                                            Percentage</label>
                                        <input type="number" class="form-control" id="assessmentPassingPercent"
                                            name="passing_percent" value="{{ $assessment->passing_percent }}"
                                            min="0" max="100">
                                    </div>
                                </div>

                                <!-- Difficulty Level -->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="assessmentDifficulty" class="form-label">Difficulty Level</label>
                                        <select class="form-select" id="assessmentDifficulty" name="difficulty_level">
                                            @foreach (App\Enums\DifficultyLevelEnum::cases() as $difficulty)
                                                <option value="{{ $difficulty->value }}"
                                                    {{ $assessment->difficulty_level == $difficulty->value ? 'selected' : '' }}>
                                                    {{ $difficulty->label() }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Row for Checkbox Options (Auto Grade, Active, Access) -->
                            <div class="row g-4">
                                <!-- Auto Grade -->
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input hidden name="auto_grade" value="0">
                                        <input type="checkbox" class="form-check-input" id="assessmentAutoGrade"
                                            name="auto_grade" value="1"
                                            {{ $assessment->auto_grade ? 'checked' : '' }}>
                                        <label class="form-check-label" for="assessmentAutoGrade">Auto Grade</label>
                                    </div>
                                </div>

                                <!-- Access -->
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input hidden name="access" value="public">
                                        <input type="checkbox" class="form-check-input" id="assessmentAccess"
                                            name="access" value="private"
                                            {{ $assessment->access == 'private' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="assessmentAccess">Private Access</label>
                                    </div>
                                </div>

                                <!-- Is Active (Toggle) -->
                                <div class="col-md-4">
                                    <label for="assessmentIsActive" class="form-label">Is Active</label>
                                    <div class="form-check form-switch d-inline">
                                        <input hidden name="is_active" value="0">
                                        <input type="checkbox" class="form-check-input" id="assessmentIsActive"
                                            name="is_active" value="1"
                                            {{ $assessment->is_active ? 'checked' : '' }}>
                                        <label class="form-check-label" for="assessmentIsActive"></label>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Footer -->
                            <div class="modal-footer mt-3">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-warning">Update Assessment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </x-page-section>

    <x-page-section section="Results">
        <div class="card">
            <div class="card-header">Manage Results</div>
            <div class="card-body">
                <div class="table-responsive">
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </x-page-section>
@endsection
@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
