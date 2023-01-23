<?php

namespace App\Http\Controllers\API\V1;

use App\Events\CourseDeleted;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\CourseRequest;
use App\Http\Resources\CoursesResource;
use App\Models\Course;
use Symfony\Component\HttpFoundation\Response;

class CoursesController extends Controller
{

    public function index(CourseRequest $request)
    {
        $courses = Course::query()->with(['department'])->get();

        return CoursesResource::collection($courses);
    }

    public function store(CourseRequest $request)
    {
        $request->validated($request->all());

        $course = Course::create([
            'c_name' => $request->name,
            'ct_id' => $request->course_type,
            'dept_id' => $request->department,
            'qualifications' => $request->qualifications,
        ]);

        return new CoursesResource($course);

    }

    public function show(CourseRequest $request, Course $course)
    {
        $course->load('courseType', 'department', 'students', 'assignments.assignmentType');

        return new CoursesResource($course);
    }

    public function update(CourseRequest $request,Course $course)
    {
        $course->update([
            'c_name' => $request->name,
            'ct_id' => $request->course_type,
            'dept_id' => $request->department,
            'qualifications' => $request->qualifications,
        ]);

        return new CoursesResource($course);
    }

    public function destroy(CourseRequest $request, Course $course)
    {
        CourseDeleted::dispatch($course);

        return response()->json($course, Response::HTTP_NO_CONTENT);
    }

}
