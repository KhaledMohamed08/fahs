<?php

namespace App\Services;

use App\Models\Result;

class ResultService extends BaseService
{
    public function __construct(protected AssessmentService $assessmentService, protected QuestionService $questionService)
    {
        parent::__construct(new Result());
    }

    public function store(array $data)
    {
        $assessment = $this->assessmentService->find($data['assessment_id'], [], ['questions']);

        $resultData = [
            'assessment_id' => $assessment->id,
            'score' => 0,
        ];

        if ($assessment->auto_grade) {
            $resultData['score'] += $this->countAnswersScore($data['answers']);
            $resultData['is_passed'] = $this->isPassed($assessment, $resultData['score']);

            if (!$this->isFreeTextQuestionExist($assessment->questions->pluck('id')))
                $resultData['status'] = 'done';
        }

        $result = $this->model->create($resultData);

        foreach ($data['answers'] as $questionId => $answer) {
            $this->storeAnswerDetails($result, $questionId, $answer);
        }

        return $result;
    }

    private function countAnswersScore(array $answers): int
    {
        return collect($answers)->reduce(function (int $total, $answer, $questionId) {

            if ($questionId == -1)
                return 0;

            $question = $this->questionService->find($questionId);

            return $total + match ($question->type) {
                'true_false' => $this->countTrueFalseAnswersScore($question, $answer),
                'multiple_choice' => $this->countMultipleChoiceAnswersScore($question, $answer),
                default => 0,
            };
        }, 0);
    }

    private function countTrueFalseAnswersScore($question, $answer): int
    {
        return $question->is_true == $answer ? (int) $question->score : 0;
    }


    private function countMultipleChoiceAnswersScore($question, $answer): int
    {
        $correctOption = collect($question['options'])->first(fn($o) => $o['is_correct'] == true);
        return $correctOption['title'] == $answer ? (int) $question->score : 0;
    }

    private function isFreeTextQuestionExist($questionIds): bool
    {
        return collect($questionIds)->contains(function ($id) {
            $question = $this->questionService->find($id);
            return $question && $question->type === 'free_text';
        });
    }

    private function storeAnswerDetails(Result $result, int|string $questionId, mixed $answer)
    {
        $question = $this->questionService->find($questionId);

        $isAutoScored = $question->type !== 'free_text';
        $isCorrect = $isAutoScored && $this->isCorrect($question, $answer);

        $details = [
            'result_id'    => $result->id,
            'question_id'  => $questionId,
            'user_answer'  => $answer,
            'score'        => $isAutoScored ? ($isCorrect ? $question->score : 0) : null,
        ];

        return $result->details()->create($details);
    }


    public function updateResultStatus(Result $result): void
    {
        if ($result->status === 'pending') {
            $result->status = 'reviewing';
            $result->save();
        }
    }

    public function submitResult(array $data, Result $result): void
    {
        $scores = $data['score'];
        $totalScore = array_sum($scores);

        foreach ($scores as $questionId => $score) {
            $detail = $result->details->firstWhere('question_id', $questionId);
            if ($detail) {
                $detail->update(['score' => $score]);
            }
        }

        $result->update([
            'status' => 'done',
            'score' => $totalScore,
            'is_passed' => $this->isPassed($result->assessment, $totalScore),
        ]);
    }

    private function isCorrect($question, $answer): bool
    {
        switch ($question->type) {
            case 'multiple_choice':
                $correctAnswer = collect($question->options)
                    ->first(fn($opt) => $opt['is_correct'] == 'true')['title'];
                return $correctAnswer === $answer;

            case 'true_false':
                return $question->is_true == $answer;

            default:
                return false;
        }
    }

    private function isPassed($assessment, int $totalScore): bool
    {
        $fullScore = $assessment->fullScore();
        $requiredScore = ($assessment->passing_percent / 100) * $fullScore;

        return $totalScore >= $requiredScore;
    }
}
