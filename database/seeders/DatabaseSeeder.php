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
        AssignmentType::factory(5)->create();
        CourseType::factory(5)->create();

        Course::factory(20)->create();

        Student::factory(100)->create();
        Attendance::factory(20)->create();
        Assignment::factory(20)->create();
    }
}

