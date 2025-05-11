@extends('layouts.main')
@section('title', 'Assessment Questions')

@section('content')
    <x-page-title />

    <x-page-section section="Questions Of {{ $assessment->title }}">
        @forelse ($assessment->questions as $question)
            <div class="mb-4 p-4 border rounded shadow-sm">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <h5 class="fw-semibold mb-1">Q{{ $loop->iteration }}: {{ $question->title }}</h5>
                    </div>
                    <div class="d-flex align-items-center justify-content-end gap-2">
                        <span class="badge bg-success fs-6 py-2">Score: {{ $question->score }}</span>
                        <button class="btn btn-sm btn-warning d-flex align-items-center gap-1"
                            data-bs-toggle="modal" data-bs-target="#editQuestionModal{{ $question->id }}">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                    </div>
                </div>

                @switch($question->type)
                    @case('multiple_choice')
                        @if ($question->options)
                            <ul class="list-group list-group-flush mt-2">
                                @foreach ($question->options as $option)
                                    <li class="list-group-item {{ $option['is_correct'] == 'true' ? 'bg-success text-white' : '' }}">
                                        {{ chr(64 + $loop->iteration) }}. {{ $option['title'] ?? $option }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        @break

                    @case('true_false')
                        <p class="mt-2">Answer:
                            <strong class="text-{{ $question->is_true ? 'success' : 'danger' }}">
                                {{ $question->is_true ? 'True' : 'False' }}
                            </strong>
                        </p>
                        @break

                    @case('free_text')
                        <p class="mt-2 text-muted"><em>Free text answer</em></p>
                        @if ($question->text_answer_model)
                            <p><strong>Model Answer:</strong> {{ $question->text_answer_model }}</p>
                        @endif
                        @break
                @endswitch
            </div>

            <!-- Edit Question Modal -->
            <div class="modal fade" id="editQuestionModal{{ $question->id }}" tabindex="-1"
                aria-labelledby="editQuestionModalLabel{{ $question->id }}" aria-hidden="true"
                data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form action="{{ route('questions.update', $question->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="modal-header">
                                <h5 class="modal-title" id="editQuestionModalLabel{{ $question->id }}">Edit Question</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="questionTitle{{ $question->id }}" class="form-label">Title</label>
                                    <input type="text" class="form-control" id="questionTitle{{ $question->id }}"
                                        name="title" value="{{ $question->title }}" required>
                                </div>
                            
                                <div class="mb-3">
                                    <label for="questionScore{{ $question->id }}" class="form-label">Score</label>
                                    <input type="number" class="form-control" id="questionScore{{ $question->id }}"
                                        name="score" value="{{ $question->score }}" required min="0">
                                </div>
                            
                                <div class="mb-3">
                                    <label for="questionType{{ $question->id }}" class="form-label">Question Type</label>
                                    <select class="form-select" id="questionType{{ $question->id }}" name="type" required>
                                        <option value="multiple_choice" {{ $question->type === 'multiple_choice' ? 'selected' : '' }}>Multiple Choice</option>
                                        <option value="true_false" {{ $question->type === 'true_false' ? 'selected' : '' }}>True / False</option>
                                        <option value="free_text" {{ $question->type === 'free_text' ? 'selected' : '' }}>Free Text</option>
                                    </select>
                                </div>
                            </div>
                            

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        @empty
            <p class="text-muted">No questions found for this assessment.</p>
        @endforelse
        <a class="btn btn-primary" href="{{ route('assessments.show', $assessment->id) }}">Back to Assessment</a>
    </x-page-section>
@endsection
