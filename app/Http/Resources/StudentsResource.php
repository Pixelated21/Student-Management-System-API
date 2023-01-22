<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentsResource extends JsonResource
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
            'id' => $this->s_id,
            'attributes' => [
                'name' => $this->name,
                'mobile' => $this->mobile,
                'email' => $this->email_id,
                'address' => $this->address,
                'section' => $this->section,
                'course' => $this->c_id,
                'status' => $this->status,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
            'relationships' => [
                'course' => new CoursesResource($this->whenLoaded('course')),
                'attendances' => AttendancesResource::collection($this->whenLoaded('attendances')),
                'assignments' => AssignmentsResource::collection($this->whenLoaded('assignments')),
            ]
        ];
    }
}
