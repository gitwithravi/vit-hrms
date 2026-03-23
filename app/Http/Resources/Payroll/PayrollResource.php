<?php

namespace App\Http\Resources\Payroll;

use App\Enums\Finance\PaymentStatus;
use App\Http\Resources\Employee\EmployeeSummaryResource;
use App\Models\Attendance\Type as AttendanceType;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class PayrollResource extends JsonResource
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
            'code_number' => $this->code_number,
            'salary_structure' => SalaryStructureResource::make($this->whenLoaded('salaryStructure')),
            'employee' => EmployeeSummaryResource::make($this->whenLoaded('employee')),
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'period' => $this->period,
            'duration' => $this->duration,
            'total' => $this->total,
            'paid' => $this->paid,
            'is_paid' => $this->total->value > $this->paid->value ? false : true,
            'status' => PaymentStatus::getDetail($this->status),
            'remarks' => $this->remarks,
            'net_earning' => \Price::from($this->getMeta('actual.earning')),
            'net_deduction' => \Price::from($this->getMeta('actual.deduction')),
            'net_salary' => \Price::from($this->getMeta('actual.earning') - $this->getMeta('actual.deduction')),
            $this->mergeWhen($request->show_attendance_summary, [
                'attendance_summary' => $this->getAttendanceSummary(),
            ]),
            'records' => RecordResource::collection($this->whenLoaded('records')),
            'created_at' => \Cal::dateTime($this->created_at),
            'updated_at' => \Cal::dateTime($this->updated_at),
        ];
    }

    private function getAttendanceSummary()
    {
        $attendanceTypes = AttendanceType::byTeam()->get();

        $attendances = [];
        $payrollAttendances = $this->getMeta('attendances') ?? [];
        foreach ($payrollAttendances as $attendance) {
            if (Arr::get($attendance, 'code') == 'L') {
                $attendances[] = Arr::add($attendance, 'name', trans('leave.leave'));
            }

            $attendanceType = $attendanceTypes->firstWhere('code', Arr::get($attendance, 'code'));

            if ($attendanceType) {
                $attendances[] = Arr::add($attendance, 'name', $attendanceType->name);
            }
        }

        return $attendances;
    }
}
