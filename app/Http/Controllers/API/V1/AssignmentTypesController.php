<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\AssignmentTypeRequest;
use App\Http\Resources\AssignmentTypesResource;
use App\Models\AssignmentType;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AssignmentTypesController extends Controller
{
    public function index(AssignmentTypeRequest $request)
    {
        $assignment_types = AssignmentType::query()->get();

        return AssignmentTypesResource::collection($assignment_types);
    }

    public function store(AssignmentTypeRequest $request)
    {
        $request->validated($request->all());

        $assignment_type = AssignmentType::create([
            'asst_name' => $request->name,
        ]);

        return new AssignmentTypesResource($assignment_type);
    }

    public function show(AssignmentTypeRequest $request, AssignmentType $assignment_type)
    {
        return new AssignmentTypesResource($assignment_type);
    }

    public function update(AssignmentTypeRequest $request, AssignmentType $assignment_type)
    {
        $assignment_type->update([
            'asst_name' => $request->name,
        ]);

        return new AssignmentTypesResource($assignment_type);
    }

    public function destroy(AssignmentTypeRequest $request, AssignmentType $assignment_type)
    {
        $assignment_type->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
