<?php

namespace App\Http\Resources\Employee;

use Illuminate\Http\Resources\Json\JsonResource;

class MediclaimDependantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'relationship' => $this->relationship,
            'relationship_label' => $this->relationship_label,
            'top_up' => $this->top_up,
            'top_up_label' => $this->top_up_label,
            'employee' => $this->whenLoaded('employee', fn () => [
                'uuid' => $this->employee->uuid,
                'code_number' => $this->employee->code_number,
                'name' => $this->employee->name,
                'department' => $this->employee->department_name ?? '-',
                'designation' => $this->employee->designation_name ?? '-',
            ]),
            'created_at' => \Cal::dateTime($this->created_at),
            'updated_at' => \Cal::dateTime($this->updated_at),
        ];
    }
}
