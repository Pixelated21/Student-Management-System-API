<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentsResource extends JsonResource
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
            'id' => $this->dept_id,
            'attributes' => [
                'name' => $this->d_name,
                'updated_at' => $this->updated_at,
                'created_at' => $this->created_at,
            ],
            'relationships' => [
                'courses' => CoursesResource::collection($this->whenLoaded('courses')),
            ]
        ];
    }
}
