<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\AttendanceRequest;
use App\Http\Resources\AttendancesResource;
use App\Models\Attendance;
use App\Models\Course;
use App\Models\Student;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AttendanceController extends Controller
{

    use HttpResponses;

    public function index(AttendanceRequest $request)
    {
        // Instantiate a new Department model
        $attendances = Attendance::query()->with(['course', 'student'])->get();

        return AttendancesResource::collection($attendances);
    }

    public function show(AttendanceRequest $request, Attendance $attendance)
    {
        // Instantiate a new Attendance model
        $attendance->load(['course', 'student']);

        return new AttendancesResource($attendance);
    }

    public function store(AttendanceRequest $request)
    {
        $department = Attendance::create([
            'student_id' => $request->student,
            'course_id' => $request->course,
            'p/a' => $request->is_present,
            'total_classes' => $request->total_classes,
        ]);

        return new AttendancesResource($department);
    }

    public function update(AttendanceRequest $request, Attendance $attendance)
    {
        $attendance->update([
            'student_id' => $request->student,
            'course_id' => $request->course,
            'p/a' => $request->is_present,
            'total_classes' => $request->total_classes,
        ]);

        return new AttendancesResource($attendance);
    }

    public function destroy(AttendanceRequest $request, Attendance $attendance)
    {
        $attendance->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
