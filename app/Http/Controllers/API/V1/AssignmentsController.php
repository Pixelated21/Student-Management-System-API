<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\AssignmentRequest;
use App\Http\Resources\AssignmentsResource;
use App\Models\Assignment;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AssignmentsController extends Controller
{

    use HttpResponses;

    public function index(AssignmentRequest $request)
    {
        // Instantiate a new Department model
        $assignments = Assignment::query()->get();

        return AssignmentsResource::collection($assignments);
    }

    public function show(AssignmentRequest $request, Assignment $assignment)
    {
        // Instantiate a new Department model
        return new AssignmentsResource($assignment);
    }

    public function store(AssignmentRequest $request)
    {
        $request->validated($request->all());

        $department = Assignment::create([
            'd_name' => $request->name,
        ]);

        return new AssignmentsResource($department);
    }

    public function update(AssignmentRequest $request, Assignment $department)
    {
        $department->update([
            'd_name' => $request->name,
        ]);

        return new AssignmentsResource($department);
    }

    public function destroy(AssignmentRequest $request, Assignment $department)
    {
        $department->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);

    }
}
