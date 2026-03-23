<?php

namespace App\Http\Resources\Payroll;

use App\Enums\Attendance\ProductionUnit as AttendanceProductionUnit;
use App\Enums\Payroll\PayHeadType;
use App\Enums\Payroll\SalaryStructureUnit;
use App\Http\Resources\Attendance\TypeResource as AttendanceTypeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SalaryTemplateRecordResource extends JsonResource
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
            'pay_head' => PayHeadResource::make($this->whenLoaded('payHead')),
            'attendance_type' => AttendanceTypeResource::make($this->whenLoaded('attendanceType')),
            'type' => PayHeadType::getDetail($this->type),
            $this->mergeWhen($this->type != PayHeadType::PRODUCTION_BASED->value, [
                'unit' => SalaryStructureUnit::getDetail('monthly'),
            ]),
            $this->mergeWhen($this->type == PayHeadType::PRODUCTION_BASED->value, [
                'unit' => AttendanceProductionUnit::getDetail('hourly'),
            ]),
            'enable_user_input' => $this->enable_user_input,
            'position' => $this->position,
            'computation' => $this->computation,
            'created_at' => \Cal::dateTime($this->created_at),
            'updated_at' => \Cal::dateTime($this->updated_at),
        ];
    }
}
