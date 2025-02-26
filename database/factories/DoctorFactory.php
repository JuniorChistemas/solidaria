<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->numerify('DOC###'),
            'name' => $this->faker->name(),
            'start_date' => $this->faker->dateTimeBetween('-5 years', 'now'),
            'state' => $this->faker->boolean(),
        ];
    }
}
