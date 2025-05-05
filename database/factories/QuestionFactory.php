<?php

namespace Database\Factories;

use App\Models\Assessment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(['free_text', 'true_false', 'multiple_choice']);

        $base = [
            'assessment_id' => Assessment::inRandomOrder()->value('id'),
            'user_id' => User::inRandomOrder()->value('id'),
            'type' => $type,
            'title' => fake()->sentence(7),
            'score' => fake()->randomElement([10, 20, 30]),
            'is_true' => null,
            'options' => null,
            'text_answer_model' => null,
        ];

        return match ($type) {
            'true_false' => [
                ...$base,
                'is_true' => fake()->boolean(),
            ],
            'multiple_choice' => [
                ...$base,
                'options' => (function () {
                    $total = rand(3, 5);
                    $correctIndex = rand(0, $total - 1);
                    return collect(range(0, $total - 1))
                        ->map(fn($i) => [
                            'title' => fake()->sentence(rand(3, 6)),
                            'is_correct' => $i === $correctIndex,
                        ])
                        ->toArray();
                })(),
            ],
            'free_text' => [
                ...$base,
                'text_answer_model' => fake()->optional()->text(),
            ],

            default => $base,
        };
    }
}
