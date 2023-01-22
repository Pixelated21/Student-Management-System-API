<?php

namespace Database\Factories;

use App\Models\CourseType;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'c_id' => $this->faker->uuid(),
            'c_name' => $this->faker->name(),
            'ct_id' => CourseType::all()->random()->ct_id,
            'dept_id' => Department::all()->random()->dept_id,
            'qualifications' => $this->faker->randomElements(['A', 'B', 'C', 'D', 'E'],$this->faker->numberBetween(1,5)),
        ];
    }
}
