<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->jobTitle,
            'category_id' => fake()->numberBetween(1, 4),
            'job_type_id' => fake()->numberBetween(1, 4),
            'user_id' => fake()->numberBetween(1, 3),
            'vacancy' => fake()->numberBetween(1, 10000),
            'salary' => fake()->numberBetween(1, 10000),
            'location' => fake()->address(),
            'description' => fake()->paragraphs(3, true),
            'benifits' => fake()->words(4, true),
            'responsibility' => fake()->paragraphs(3, true),
            'qualifications' => fake()->words(5, true),
            'keywords' => fake()->words(4, true),
            'experiance' => fake()->numberBetween(12, 150),
            'company_name' => fake()->sentence(5),
            'company_location' => fake()->address(),
            'company_website' => fake()->url()
        ];
    }
}
