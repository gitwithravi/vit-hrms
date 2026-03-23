<?php

namespace App\Http\Resources\Employee;

use App\Enums\Employee\Status;
use App\Enums\Gender;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $status = Status::ACTIVE;

        if ($this->leaving_date->value && $this->leaving_date->value < today()->toDateString()) {
            $status = Status::INACTIVE;
        }

        $birthDate = \Cal::date($this->birth_date);
        $startDate = \Cal::date($this->start_date);
        $endDate = \Cal::date($this->end_date);

        return [
            'uuid' => $this->uuid,
            'code_number' => $this->code_number,
            'name' => $this->name,
            'employment_status' => $this->employment_status_name ?? '-',
            'department' => $this->department_name ?? '-',
            'designation' => $this->designation_name ?? '-',
            'branch' => $this->branch_name ?? '-',
            'employment_status_uuid' => $this->employment_status_uuid,
            'department_uuid' => $this->department_uuid,
            'designation_uuid' => $this->designation_uuid,
            'branch_uuid' => $this->branch_uuid,
            'is_default' => $this->is_default,
            'gender' => Gender::getDetail($this->gender),
            'photo' => $this->photo_url,
            'self' => $this->user_id == auth()->id() ? true : false,
            'birth_date' => $birthDate,
            'age' => $birthDate->age,
            'joining_date' => $this->joining_date,
            'leaving_date' => $this->leaving_date,
            'period' => $this->period,
            'status' => Status::getDetail($status),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'created_at' => \Cal::dateTime($this->created_at),
        ];
    }
}
