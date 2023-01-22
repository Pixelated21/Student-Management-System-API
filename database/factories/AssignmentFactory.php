<?php

namespace Database\Factories;

use App\Models\AssignmentType;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Assignment>
 */
class AssignmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'ass_id' => $this->faker->uuid(),
            'ass_name' => $this->faker->name(),
            's_id' => Student::all()->random()->s_id,
            'c_id' => Course::all()->random()->c_id,
            'asst_id' => AssignmentType::all()->random()->asst_id,
            'marks' => $this->faker->numberBetween(0,100),
        ];
    }
}
