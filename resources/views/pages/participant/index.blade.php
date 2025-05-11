@extends('layouts.main')

@section('title', 'Paricipant')

@section('content')
    <x-page-title />

    <x-page-section section="Assessments"
        description="Explore a wide range of assessments tailored to your field. Take more challenges, track your progress, and continuously sharpen your skills."
        containerClass="container-fluid" containerId="assessments-container">
        <div class="row">
            {{-- Filter Sidebar --}}
            <div class="col-md-3">
                <form method="GET" action="#" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search by code..."
                            value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </form>
                <div class="card mb-4">
                    <div class="card-header">Filters</div>
                    <div class="card-body">
                        <form method="GET" action="#">
                            <div class="mb-3">
                                <label for="difficulty-level" class="form-label">Assessment Difficulty</label>
                                <select name="difficulty_level" id="difficulty-level" class="form-control">
                                    <option value="" {{ request('difficulty_level') === null ? 'selected' : '' }}>All
                                    </option>
                                    <option value="1" {{ request('difficulty_level') == '1' ? 'selected' : '' }}>Easy
                                    </option>
                                    <option value="2" {{ request('difficulty_level') == '2' ? 'selected' : '' }}>Medium
                                    </option>
                                    <option value="3" {{ request('difficulty_level') == '3' ? 'selected' : '' }}>Hard
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="category-id" class="form-label">Category</label>
                                <select name="category_id" id="category-id" class="form-control">
                                    <option value="" {{ request('category_id') === null ? 'selected' : '' }}>All
                                    </option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <input type="checkbox" name="duration_minutes" id="has-no-timer" value="null"
                                    {{ request('duration_minutes') == 'null' ? 'checked' : '' }}>
                                <label for="has-no-timer">Has No Timer</label>
                            </div>
                            <div class="mb-3">
                                <input type="checkbox" name="auto_grade" id="auto-grade" value="1"
                                    {{ request('auto_grade') == '1' ? 'checked' : '' }}>
                                <label for="auto-grade">Auto Grade</label>
                            </div>
                            <button class="btn btn-sm btn-primary" type="submit">Apply</button>
                            <a href="{{ route('get.started') }}" class="btn btn-sm btn-secondary" type="reset">Reset
                                Filters</a>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Assessment Cards --}}
            <div class="col-md-9">
                @if ($assessments->count())
                    <div class="row row-cols-2 row-cols-md-4 g-4">
                        @foreach ($assessments as $assessment)
                            <div class="col">
                                <div class="card position-relative h-100 d-flex flex-column">

                                    {{-- Difficulty Badge (top-right) --}}
                                    <span
                                        class="position-absolute top-0 end-0 m-2 badge bg-{{ App\Enums\DifficultyLevelEnum::from($assessment->difficulty_level)->badge() }}">
                                        {{ App\Enums\DifficultyLevelEnum::from($assessment->difficulty_level)->label() }}
                                    </span>

                                    {{-- Card Image --}}
                                    <img src="{{ asset('assets/img/features-illustration-1.webp') }}" class="card-img-top"
                                        alt="assessment-image">

                                    {{-- Card Body --}}
                                    <div class="card-body d-flex flex-column">
                                        {{-- Title --}}
                                        <h5 class="card-title text-truncate" title="{{ $assessment->title }}">
                                            {{ Str::limit($assessment->title, 50) }}
                                        </h5>

                                        {{-- Metadata --}}
                                        <div class="text-muted small mb-3">
                                            {{-- User --}}
                                            <div class="d-flex align-items-center me-2 my-2 fw-bolder">
                                                <i class="bi bi-person-circle me-1"></i>
                                                <span title="{{ $assessment->user->name }}" class="text-truncate">
                                                    {{ Str::limit($assessment->user->name, 40) }}
                                                </span>
                                            </div>
                                            <div class="d-flex justify-content-between flex-wrap gap-2">
                                                {{-- Category --}}
                                                <div class="d-flex align-items-center me-2">
                                                    <i class="bi bi-tag-fill me-1"></i>
                                                    <span class="text-truncate" style="max-width: 100px;"
                                                        title="{{ $assessment->category->title }}">
                                                        {{ Str::limit($assessment->category->title, 15) }}
                                                    </span>
                                                </div>
                                                {{-- Date --}}
                                                <div class="d-flex align-items-center me-2">
                                                    <i class="bi bi-calendar-event me-1"></i>
                                                    {{ $assessment->created_at->format('M d, Y') }}
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between flex-wrap gap-2">
                                                {{-- Timer --}}
                                                <div class="d-flex align-items-center mt-2">
                                                    <i class="bi bi-clock me-1"></i>
                                                    {{ $assessment->duration_minutes > 0 ? $assessment->duration_minutes . ' mins' : '--' }}
                                                </div>
                                                {{-- Auto Grading --}}
                                                <div class="d-flex align-items-center me-2">
                                                    <i class="bi bi-check2-square me-1"></i>
                                                    {{ $assessment->auto_grade ? 'Auto Grading' : 'Manual Grading' }}
                                                </div>
                                            </div>
                                        </div>

                                        {{-- CTA Button --}}
                                        @if ($resultsAssessmentsIds->contains($assessment->id))
                                            <span class="text-success fw-semibold">
                                                Assessment taken.
                                                <a href="#" class="fw-normal">show result</a>
                                            </span>
                                        @else
                                            <a href="{{ route('assessments.policy', $assessment->id) }}"
                                                class="btn btn-primary">
                                                Take Assessment
                                            </a>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    @if ($assessments instanceof \Illuminate\Contracts\Pagination\Paginator)
                        <div class="mt-4">
                            {{ $assessments->withQueryString()->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center fw-bold">
                        No assessments found.
                    </div>
                @endif
            </div>
        </div>
    </x-page-section>
@endsection
@push('styles')
    <style>
        #assessments-container {
            width: 95%;
        }
    </style>
@endpush
