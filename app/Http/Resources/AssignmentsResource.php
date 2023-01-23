<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AssignmentsResource extends JsonResource
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
            'id' => $this->ass_id,
            'attributes' => [
                'name' => $this->ass_name,
                'mark' => $this->marks,
                'updated_at' => $this->updated_at,
                'created_at' => $this->created_at,
            ],
            'relationships' => [
                'type' => new AssignmentTypesResource($this->whenLoaded('assignmentType')),
            ]
        ];
    }
}
