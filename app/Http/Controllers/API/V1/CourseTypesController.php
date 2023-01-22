<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\CourseTypeRequest;
use App\Http\Resources\CourseTypesResource;
use App\Models\CourseType;
use Symfony\Component\HttpFoundation\Response;

class CourseTypesController extends Controller
{
    public function index(CourseTypeRequest $request)
    {
        $course_types = CourseType::query()->get();

        return CourseTypesResource::collection($course_types);
    }

    public function store(CourseTypeRequest $request)
    {
        $request->validated($request->all());

        $course_type = CourseType::create([
            'ct_name' => $request->name,
        ]);

        return new CourseTypesResource($course_type);
    }

    public function show(CourseTypeRequest $request, CourseType $course_type)
    {
        return new CourseTypesResource($course_type);
    }

    public function update(CourseTypeRequest $request, CourseType $course_type)
    {
        $course_type->update([
            'ct_name' => $request->name,
        ]);

        return new CourseTypesResource($course_type);
    }

    public function destroy(CourseTypeRequest $request, CourseType $course_type)
    {
        $course_type->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
