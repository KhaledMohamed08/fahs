@extends('layouts.main')
@section('title', 'Result Details')

@section('content')
    <x-page-title />

    <x-page-section section="Result Of {{ $result->assessment->title }}">
        @forelse ($result->assessment->questions as $question)
            @php
                $questionDetails = $result->details->firstWhere('question_id', $question->id);
                $userAnswer = $questionDetails->user_answer ?? null;
                $isCorrect = false;

                if ($question->type === 'multiple_choice') {
                    $correctAnswer = collect($question->options)->first(fn($opt) => $opt['is_correct'] == true);
                    $isCorrect = $correctAnswer && $correctAnswer['title'] === $userAnswer;
                } elseif ($question->type === 'true_false') {
                    $isCorrect = $question->is_true == $userAnswer;
                }
            @endphp

            <div class="mb-4 p-4 border rounded shadow-sm">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h5 class="fw-semibold mb-1">Q{{ $loop->iteration }}: {{ $question->title }}</h5>

                    <div class="input-group" style="width: 170px;">
                        <span class="input-group-text">
                            Score&nbsp;<strong>({{ $question->score }})</strong>
                        </span>
                        <input type="number" value="{{ $questionDetails?->score ?? 0 }}" class="form-control" disabled />
                    </div>
                </div>

                @switch($question->type)
                    @case('multiple_choice')
                        <ul class="list-group list-group-flush mt-2">
                            @foreach ($question->options as $option)
                                @php
                                    $optTitle = $option['title'] ?? $option;
                                    $correct = $option['is_correct'] === true || $option['is_correct'] === 'true';
                                    $selected = $userAnswer === $optTitle;
                                    $classes = [];

                                    if ($correct) {
                                        $classes[] = 'text-success';
                                        if ($selected) {
                                            $classes[] = 'bg-success-subtle';
                                        }
                                    } elseif ($selected) {
                                        $classes[] = 'bg-danger-subtle text-danger';
                                    }
                                @endphp
                                <li class="list-group-item {{ implode(' ', $classes) }}">
                                    {{ chr(64 + $loop->iteration) }}. {{ $optTitle }}
                                </li>
                            @endforeach
                        </ul>
                    @break

                    @case('true_false')
                        <div class="mt-2">
                            <p>Your Answer:
                                <strong class="text-{{ $userAnswer == 1 ? 'success' : 'danger' }}">
                                    {{ $userAnswer == 1 ? 'True' : 'False' }}
                                </strong>
                            </p>
                            <p>Model Answer:
                                <strong class="text-{{ $question->is_true ? 'success' : 'danger' }}">
                                    {{ $question->is_true ? 'True' : 'False' }}
                                </strong>
                            </p>
                        </div>
                    @break

                    @case('free_text')
                        <p class="fw-semibold">Your Answer:</p>
                        <div class="border rounded p-2 bg-light">{!! $userAnswer !!}</div>

                        @if ($question->text_answer_model)
                            <p class="fw-semibold mt-3">Model Answer:</p>
                            <div class="border rounded p-2 bg-light">{!! $question->text_answer_model !!}</div>
                        @endif
                    @break
                @endswitch
            </div>
            @empty
                <p class="text-muted">No questions found for this assessment.</p>
            @endforelse

            <div class="text-end mt-4">
                <h5><a href="{{ route('results.show', $result->id) }}">Back</a></h5>
            </div>
    </x-page-section>
@endsection
