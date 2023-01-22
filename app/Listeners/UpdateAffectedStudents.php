<?php

namespace App\Listeners;

use App\Events\CourseDeleted;
use App\Models\Course;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateAffectedStudents
{

    // protected $course;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\CourseDeleted  $event
     * @return void
     */
    public function handle(CourseDeleted $event)
    {
        $students = $event->course->students;

        foreach ($students as $student) {
            app('log')->info('You have been removed from: ' . $event->course->c_name. '---- Contact your department for more information');
            $student->course()->dissociate()->save();
        }

        $event->course->delete();
    }
}
