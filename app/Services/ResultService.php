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

            if (!$this->isFreeTextQuestionExist($assessment->questions->pluck('id')))
                $resultData['status'] = 'done';
        } 

        $result = $this->model->create($resultData);

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

    public function updateResultStatus(Result $result)
    {
        if ($result->status === 'pending') {
            $result->status = 'reviewing';
            $result->save();
        }
    }
}
