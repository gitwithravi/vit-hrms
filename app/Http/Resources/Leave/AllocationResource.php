<?php

namespace App\Http\Resources\Leave;

use App\Http\Resources\Employee\EmployeeSummaryResource;
use Cal;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AllocationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'employee' => EmployeeSummaryResource::make($this->whenLoaded('employee')),
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'description' => $this->description,
            'records' => AllocationRecordResource::collection($this->whenLoaded('records')),
            'created_at' => Cal::dateTime($this->created_at),
            'updated_at' => Cal::dateTime($this->updated_at),
        ];
    }
}
