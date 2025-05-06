@extends('layouts.main')
@section('title', 'Profile')
@section('content')
    <x-page-title />
    <h1 class="text-center mt-5">Profile Page</h1>
    <x-page-section class="stats section p-0">
        <div class="row gy-4">

            <div class="col-lg-4 col-md-6">
                <div class="stats-item text-center w-100 h-100">
                    <span data-purecounter-start="0" data-purecounter-end="{{ $assessments->count() }}"
                        data-purecounter-duration="1" class="purecounter"></span>
                    <p>Assessments</p>
                </div>
            </div>
            {{-- End Stats Item --}}

            <div class="col-lg-4 col-md-6">
                <div class="stats-item text-center w-100 h-100">
                    <span data-purecounter-start="0" data-purecounter-end="521" data-purecounter-duration="1"
                        class="purecounter"></span>
                    <p>Attends</p>
                </div>
            </div>
            {{-- End Stats Item --}}

            <div class="col-lg-4 col-md-6">
                <div class="stats-item text-center w-100 h-100">
                    <span data-purecounter-start="0" data-purecounter-end="1453" data-purecounter-duration="1"
                        class="purecounter"></span>
                    <p>participant</p>
                </div>
            </div>
            {{-- End Stats Item --}}

        </div>
    </x-page-section>
    <x-page-section section="Our Assessments" containerClass="container-fluid">
        <div class="row">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Difficulty</th>
                            <th>Passing %</th>
                            <th>Auto Grade</th>
                            <th>Access</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        @forelse ($assessments as $assessment)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $assessment->code }}</td>
                                <td class="text-start">{{ $assessment->title }}</td>
                                <td>{{ $assessment->category->title }}</td>
                                <td>
                                    <span
                                        class="badge text-bg-{{ App\Enums\DifficultyLevelEnum::from($assessment->difficulty_level)->badge() }} fs-6 fw-normal">
                                        {{ App\Enums\DifficultyLevelEnum::from($assessment->difficulty_level)->label() }}
                                    </span>
                                </td>
                                <td>{{ $assessment->passing_percent }}%</td>
                                <td class="text-{{ $assessment->auto_grade ? 'success' : 'danger' }}">
                                    {{ $assessment->auto_grade ? 'Enabled' : 'Disabled' }}
                                </td>
                                <td class="text-{{ $assessment->access === 'public' ? 'primary' : 'secondary' }}">
                                    {{ ucfirst($assessment->access) }}
                                </td>
                                <td>{{ $assessment->duration_minutes > 0 ? $assessment->duration_minutes . ' mins' : '--' }}
                                </td>
                                <td>
                                    <span class="badge text-bg-{{ $assessment->is_active ? 'success' : 'danger' }} fs-6 fw-normal">
                                        {{ $assessment->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>{{ $assessment->created_at->format('d M, Y') }}</td>
                                <td class="d-flex flex-wrap gap-1 justify-content-center">
                                    <a href="#" class="btn btn-sm btn-primary">Edit</a>
                                    <a href="#" class="btn btn-sm btn-success">View</a>
                                    <a href="#" class="btn btn-sm btn-warning">Delete</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="text-muted">No assessments available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </x-page-section>

@endsection
