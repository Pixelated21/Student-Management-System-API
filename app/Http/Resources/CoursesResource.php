<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CoursesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->c_id,
            'attributes' => [
                'name' => $this->c_name,
                'qualifications' => $this->qualifications,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
            'relationships' => [
                'course_type' => new CourseTypesResource($this->whenLoaded('courseType')),
                'department' => new DepartmentsResource($this->whenLoaded('department')),
                'students' =>  StudentsResource::collection($this->whenLoaded('students')),
                'assignments' => AssignmentsResource::collection($this->whenLoaded('assignments')),
            ]
        ];
    }
}
