<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Assessment>
 */
class AssessmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'title' => fake()->sentence(3),
            'description' => fake()->paragraphs(2, true),
            'difficulty_level' => fake()->numberBetween(1, 3),
            'passing_percent' => fake()->numberBetween(50, 85),
            'auto_grade' => fake()->boolean(),
            'access' => fake()->randomElement(['public', 'private']),
            'duration_minutes' => fake()->boolean(50) ? fake()->randomElement([30, 60, 90, 120]) : 0,
            'category_id' => Category::inRandomOrder()->value('id'),
            'user_id' => User::where('type', 'foundation')->inRandomOrder()->value('id'),
        ];
    }
}
