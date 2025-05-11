<?php

namespace Database\Seeders;

use App\Models\Assessment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssessmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Assessment::factory(50)->create();

        $assessment = Assessment::create([
            'title' => 'Test Assessment',
            'description' => 'Test Assessment Description.',
            'category_id' => 1,
            'user_id' => 1,
        ]);

        $questions = [
            [
                'title' => 'Free text without model answer.',
                'type' => 'free_text',
            ],
            [
                'title' => 'Free text with model answer.',
                'type' => 'free_text',
                'text_answer_model' => 'This is answer model to be guid for grading.',
            ],
            [
                'title' => 'True Or False (True).',
                'type' => 'true_false',
                'is_true' => true,
            ],
            [
                'title' => 'True Or False (False).',
                'type' => 'true_false',
                'is_true' => false,
            ],
            [
                'title' => 'First option is correct',
                'type' => 'multiple_choice',
                'options' => [
                    ['title' => 'option 1', 'is_correct' => true],
                    ['title' => 'option 2', 'is_correct' => false],
                    ['title' => 'option 3', 'is_correct' => false],
                ],
            ],
            [
                'title' => 'Second option is correct',
                'type' => 'multiple_choice',
                'options' => [
                    ['title' => 'option 1', 'is_correct' => false],
                    ['title' => 'option 2', 'is_correct' => true],
                    ['title' => 'option 3', 'is_correct' => false],
                ],
            ],
        ];

        foreach ($questions as $qData) {
            $question = $assessment->questions()->create($qData);
        }
    }
}
