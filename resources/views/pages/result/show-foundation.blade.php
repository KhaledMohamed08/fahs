@extends('layouts.main')
@section('title', 'Result Details')

@section('content')
    <x-page-title />

    <x-page-section section="Result Of {{ $result->assessment->title }}">
        
        {{-- Summary Info Grid --}}
        @if ($result->status === 'done')
            <div class="text-start my-4">
                <div class="mx-auto">
                    <div class="result-user text-start mb-4">
                        <h3>For User: <span>{{ $result->user->name }}</span></h3>
                    </div>
                    <div class="row row-cols-1 row-cols-md-2 g-4 mb-3 justify-content-center">
                        <x-ui.info-item icon="award" color="info" label="Full Score" :value="$result->assessment->fullScore()" />
                        <x-ui.info-item icon="percent" color="info" label="Passing Percentage" :value="number_format($result->assessment->passing_percent, 2) . '%'" />
                        <x-ui.info-item icon="check-circle" color="success" label="User Score" :value="$result->score" />
                        <x-ui.info-item icon="bar-chart" color="primary" label="User Percentage" :value="number_format(($result->score / $result->assessment->fullScore()) * 100, 2) . '%'" />
                    </div>

                    <div class="mt-3">
                        <h4>
                            Passing Status:
                            <span class="fw-semibold text-{{ $result->is_passed ? 'success' : 'danger' }}">
                                {{ $result->is_passed ? 'Passed' : 'Failed' }}
                            </span>
                        </h4>
                    </div>
                </div>
            </div>
        @endif


        <form method="POST" action="{{ route('results.submit', $result->id) }}">
            @csrf

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

                            <input type="number" name="score[{{ $question->id }}]"
                                value="{{ $questionDetails?->score ?? 0 }}" class="form-control"
                                {{ isset($questionDetails) && $questionDetails->score !== null ? 'readonly' : '' }}
                                min="0" max="{{ $question->score }}" />
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
                                <p>User Answer:
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
                            <p class="fw-semibold">User Answer:</p>
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
                    @if ($result->status !== 'done')
                        <button class="btn btn-success" type="submit">Submit Result</button>
                    @else
                        <h5>Result Already Submited. <a
                                href="{{ route('assessments.show', $result->assessment->id) }}">back</a></h5>
                    @endif
                </div>
            </form>
        </x-page-section>
    @endsection
