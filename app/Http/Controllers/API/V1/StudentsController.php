<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\StudentRequest;
use App\Http\Resources\StudentsResource;
use App\Models\Student;
use App\Traits\HttpResponses;
use Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentsController extends Controller
{

    use HttpResponses;

    // TODO: Add Bulk Actions

    public function results(Request $request)
    {
        // TODO: Add validation for the request

        // Instantiate a new Student model
        $query = Student::query();

        // If the request has a search_query parameter
        if ($s = $request->input('search_query')) {

            // Search the name and mobile fields for the search_query
            $query->where('name', 'like', '%' . $s . '%');


            // If the request has a sort parameter
            if ($sort = $request->input('sort')) {
                $query->orderBy('name', $sort);
            }

            // Supplementary code for pagination
            $perPage = 10;
            $page = $request->input('page', 1);
            $total = $query->count();

            // TODO Add To Request
            // Meta data for pagination
            $meta = [
                'total' => $query->count(),
                'per_page' => $perPage,
                'current_page' => $page,
                'last_page' => ceil($total / $perPage),
            ];

            // Fetches the data with pagination from the meta data
            $results = $query->offset(($page - 1) * $perPage)->limit($perPage)->get();
            return StudentsResource::collection($results);
        }

        return $this->error('', 'No search query provided', 200);
    }

    public function apply(StudentRequest $request)
    {
        // TODO: Add Constants for status
        // TODO: Send email to admin and student after application is submitted

        // Validated fields
        $validated = $request->validated();

        // Check if students email already exists within the system
        $student = Student::orEmail($validated['email'])
            ->orMobile($validated['mobile'])
            ->first();

        // If student has already submitted a request
        if ($student) {
            // If student has already applied and is under review
            if ($student->status == Student::STATUS['pending']) {
                return response()->json([
                    'messages' => ['Your request is already submitted and is under review'],
                    'data' => [],
                    'errors' => []
                ], Response::HTTP_OK);
            }

            // If student has already applied and is rejected
            if ($student->status == Student::STATUS['rejected']) {
                return response()->json([
                    'messages' => ['Your request has been rejected'],
                    'data' => [],
                    'errors' => []
                ], Response::HTTP_OK);
            }

            // If student has already applied and is approved
            if ($student->status == Student::STATUS['approved']) {
                return response()->json([
                    'messages' => ['Your request has already been approved! You can now login'],
                    'data' => [],
                    'errors' => []
                ], Response::HTTP_OK);
            }
        }

        // Checks if student has not applied before
        if (!$student) {
            // Create new student

            // TODO: create function to assign students evenly to sections and check course capacity
            // TODO: create method to store student's profile picture


            // FIXME: Dummy data for what the returned $course array should look like
            // TODO: course should be multi-select and array of courses

            $course = [
                'c_id' => $validated['c_id'],
                'section' => 'A',
            ];

            $student = new Student();
            $student->generateStudent($validated, $course);


            return response()->json([
                'messages' => ['Your request has been submitted successfully'],
                'data' => [],
                'errors' => []
            ], Response::HTTP_OK);
        }
    }

    public function index(StudentRequest $request)
    {
        // Instantiate a new Student model
        $students = Student::query()->get();

        return StudentsResource::collection($students);
    }

    public function show(StudentRequest $request, Student $student)
    {
        // Instantiate a new Student model
        $student->load(['course.courseType', 'attendances', 'assignments.assignmentType']);

        return new StudentsResource($student);
    }

    public function store(StudentRequest $request)
    {
        $request->validated($request->all());

        $student = Student::create([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email_id' => $request->email,
            'address' => $request->address,
            'c_id' => $request->course,
        ]);

        return new StudentsResource($student);
    }

    public function update(StudentRequest $request, Student $student)
    {
        $student->update([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email_id' => $request->email,
            'address' => $request->address,
            'c_id' => $request->course,
        ]);

        return new StudentsResource($student);
    }

    public function destroy(StudentRequest $request, Student $student)
    {
        $student->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    private function isNotAuthorized($student)
    {
        if (Auth::user()->id != $student->s_id) {
            return $this->error('Unauthorized', 'You are not authorized to make this request', Response::HTTP_UNAUTHORIZED);
        }
    }
}
