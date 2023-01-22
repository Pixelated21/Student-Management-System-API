<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            's_id' => $this->faker->unique()->uuid(),
            'name' => $this->faker->name(),
            'section' => $this->faker->randomElement(['A', 'B', 'C', 'D', 'E']),
            'email_id' => $this->faker->unique()->email(),
            'profile_pic' => function (array $attributes) {
                return 'https://avatar.oxro.io/avatar.svg?name='.$attributes['name'];
            },
            'c_id' => Course::all()->random()->c_id,
            'mobile' => $this->faker->unique()->phoneNumber(),
            'address' => $this->faker->address(),
            'status' => $this->faker->randomElement([...array_values(Student::STATUS)])
        ];
    }
}
