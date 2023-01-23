<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Administrator;
use App\Models\Assignment;
use App\Models\AssignmentType;
use App\Models\Attendance;
use App\Models\Course;
use App\Models\CourseType;
use App\Models\Department;
use App\Models\Product;
use App\Models\Student;
use App\Models\User;
use Database\Factories\AttendanceFactory;
use Database\Factories\CourseFactory;
use Database\Factories\ProductFactory;
use Database\Factories\StudentFactory;
use Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Administrator::create([
            'username' => 'Pixelated21',
            'password' => Hash::make('Admin!@#123'),
        ]);

        Administrator::factory(5)->create();
        Department::factory(20)->create();
        AssignmentType::factory(20)->create();
        CourseType::factory(20)->create();

        Course::factory(200)->create();

        Student::factory(500)->create();
        Attendance::factory(1000)->create();
        Assignment::factory(1000)->create();
    }
}

