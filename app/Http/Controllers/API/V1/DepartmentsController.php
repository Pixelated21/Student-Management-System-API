<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\DepartmentRequest;
use App\Http\Resources\DepartmentsResource;
use App\Models\Department;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DepartmentsController extends Controller
{

    use HttpResponses;

    public function index(DepartmentRequest $request)
    {
        // Instantiate a new Department model
        $departments = Department::query()->get();

        return DepartmentsResource::collection($departments);
    }

    public function show(DepartmentRequest $request, Department $department)
    {
        $department->load('courses');
        // Instantiate a new Department model
        return new DepartmentsResource($department);
    }

    public function store(DepartmentRequest $request)
    {
        $request->validated($request->all());

        $department = Department::create([
            'd_name' => $request->name,
        ]);

        return new DepartmentsResource($department);
    }

    public function update(DepartmentRequest $request, Department $department)
    {
        $department->update([
            'd_name' => $request->name,
        ]);

        return new DepartmentsResource($department);
    }

    public function destroy(DepartmentRequest $request, Department $department)
    {
        $department->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);

    }
}
