<?php

namespace App\Services;

use App\Models\Assessment;

class AssessmentService extends BaseService
{
    public function __construct()
    {
        parent::__construct(new Assessment());
    }

    public function store(array $data)
    {
        $questions = $data['questions'];
        unset($data['questions']);

        $assessment = $this->model->create($data);

        foreach ($questions as $question) {
            switch ($question['type']) {
                case 'free_text':
                    $this->storeFreeTextQuestion($question, $assessment);
                    break;
                case 'true_false':
                    $this->storeTrueOrFalseQuestion($question, $assessment);
                    break;
                case 'multiple_choice':
                    $this->storeMultipleChoiceQuestions($question, $assessment);
                    break;
                default:

                    break;
            }
        }

        return $assessment;
    }

    public function storeFreeTextQuestion(array $question, $assessment)
    {
        $assessment->questions()->create($question);
    }

    public function storeTrueOrFalseQuestion($question, $assessment)
    {
        $assessment->questions()->create($question);
    }

    private function storeMultipleChoiceQuestions(array $question, $assessment)
    {
        $correctIndex = $question['correct'];
        $question['options'] = array_map(function ($option, $index) use ($correctIndex) {
            return [
                'title' => $option,
                'is_correct' => $index == $correctIndex,
            ];
        }, $question['options'], array_keys($question['options']));

        unset($question['correct']);
        
        $assessment->questions()->create($question);
    }
}
