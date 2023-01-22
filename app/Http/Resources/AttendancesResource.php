<?php

namespace App\Http\Resources;

use App\Http\Requests\API\V1\StudentRequest;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendancesResource extends JsonResource
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
            'id' => $this->_id,
            'attributes' => [
                'isPresent' => $this['p/a'],
                'total_classes' => $this->total_classes
            ],
            'relationships' => [
                'course' => new CoursesResource($this->whenLoaded('course')),
                'student' => new CoursesResource($this->whenLoaded('student')),
            ]
        ];
    }
}
