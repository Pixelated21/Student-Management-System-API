<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendance>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            's_id' => Student::all()->random()->s_id,
            'c_id' => Course::all()->random()->c_id,
            'p/a' => $this->faker->boolean(),
            'total_classes' => $this->faker->numberBetween(0, 100),

        ];
    }
}
