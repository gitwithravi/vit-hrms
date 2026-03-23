<?php

namespace App\Actions\Attendance;

use App\Helpers\CalHelper;
use App\Models\Attendance\Timesheet;
use App\Models\Employee\Employee;
use App\Models\Employee\WorkShift as EmployeeWorkShift;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class StoreTimesheet
{
    public function execute(Employee $employee, string $dateTime)
    {
        try {
            Carbon::parse($dateTime);
        } catch (\Exception $e) {
            throw ValidationException::withMessages(['message' => 'Invalid date time.', 'code' => 103]);
        }

        $date = Carbon::parse($dateTime)->toDateString();

        $employeeWorkShifts = EmployeeWorkShift::query()
            ->select('work_shifts.records', 'employee_work_shifts.employee_id', 'employee_work_shifts.work_shift_id', 'employee_work_shifts.start_date', 'employee_work_shifts.end_date')
            ->join('work_shifts', function ($join) {
                $join->on('employee_work_shifts.work_shift_id', '=', 'work_shifts.id');
            })
            ->whereEmployeeId($employee->id)
            ->where(function ($q) use ($date) {
                $q->where(function ($q) use ($date) {
                    $q->where('start_date', '<=', Carbon::parse($date)->toDateString())
                        ->where('end_date', '>=', Carbon::parse($date)->toDateString());
                })->orWhere(function ($q) use ($date) {
                    $q->where('start_date', '<=', Carbon::parse($date)->subDay(1)->toDateString())
                        ->where('end_date', '>=', Carbon::parse($date)->subDay(1)->toDateString());
                });
            })
            ->get();

        if (! $employeeWorkShifts->count()) {
            return;
        }

        $attendanceDate = Carbon::parse($dateTime)->toDateString();

        if (Carbon::parse($dateTime)->toTimeString() < '09:00:00') {
            $previousAttendanceDate = Carbon::parse($dateTime)->subDay(1)->toDateString();

            $previousDayWorkShiftRecord = $this->getWorkShiftRecord($employeeWorkShifts, $previousAttendanceDate);

            $isOvernight = $this->checkIfOvernight($previousDayWorkShiftRecord);

            if ($isOvernight) {
                $attendanceDate = $previousAttendanceDate;
            }
        }

        $employeeWorkShift = $this->getEmployeeWorkShift($employeeWorkShifts, $attendanceDate);

        if (! $employeeWorkShift) {
            return;
        }

        $workShiftRecord = $this->getWorkShiftRecord($employeeWorkShifts, $attendanceDate);

        $isHoliday = $this->checkIfHoliday($workShiftRecord);

        $isOvernight = $this->checkIfOvernight($workShiftRecord);

        $attendanceDate = $this->findAttendanceDate($attendanceDate, $isOvernight);

        $this->store(employee: $employee, dateTime: $dateTime, attendanceDate: $attendanceDate, employeeWorkShift: $employeeWorkShift, isHoliday: $isHoliday, isOvernight: $isOvernight);
    }

    private function store(Employee $employee, string $dateTime, string $attendanceDate, ?EmployeeWorkShift $employeeWorkShift = null, bool $isHoliday = false, bool $isOvernight = false)
    {
        $existingTimesheet = Timesheet::query()
            ->whereEmployeeId($employee->id)
            ->where('date', $attendanceDate)
            ->where(function ($q) use ($dateTime) {
                $q->where('in_at', '=', CalHelper::storeDateTime($dateTime)->toDateTimeString())
                    ->orWhere('out_at', '=', CalHelper::storeDateTime($dateTime)->toDateTimeString());
            })
            ->orderBy('in_at', 'desc')
            ->exists();

        if ($existingTimesheet) {
            return;
        }

        $timesheet = Timesheet::query()
            ->whereEmployeeId($employee->id)
            ->where('date', $attendanceDate)
            ->orderBy('in_at', 'desc')
            ->first();

        if ($timesheet && $timesheet->in_at > CalHelper::storeDateTime($dateTime)->toDateTimeString()) {
            return;
        }

        if ($timesheet && $timesheet->out_at && $timesheet->out_at > CalHelper::storeDateTime($dateTime)->toDateTimeString()) {
            return;
        }

        if ($timesheet && ! $timesheet->out_at) {
            $meta = $timesheet->meta;
            $meta['is_holiday'] = $isHoliday;
            $meta['is_overnight'] = $isOvernight;
            $timesheet->meta = $meta;
            $timesheet->out_at = CalHelper::storeDateTime($dateTime)->toDateTimeString();
            $timesheet->save();
        } else {
            $timesheet = Timesheet::forceCreate([
                'employee_id' => $employee->id,
                'work_shift_id' => $employeeWorkShift?->work_shift_id,
                'date' => $attendanceDate,
                'in_at' => CalHelper::storeDateTime($dateTime)->toDateTimeString(),
                'meta' => [
                    'is_holiday' => $isHoliday,
                    'is_overnight' => $isOvernight,
                ],
            ]);
        }
    }

    private function getEmployeeWorkShift(Collection $employeeWorkShifts, string $date)
    {
        return $employeeWorkShifts
            ->where('start_date', '<=', $date)
            ->where('end_date', '>=', $date)
            ->first();
    }

    private function getWorkShiftRecord(Collection $employeeWorkShifts, string $date)
    {
        $employeeWorkShift = $employeeWorkShifts
            ->where('start_date', '<=', $date)
            ->where('end_date', '>=', $date)
            ->first();

        $day = strtolower(Carbon::parse($date)->format('l'));

        $workShiftRecords = json_decode($employeeWorkShift?->records, true);

        return collect($workShiftRecords)->firstWhere('day', $day) ?? null;
    }

    private function checkIfHoliday(?array $workShiftRecord = []): bool
    {
        if (! $workShiftRecord) {
            return true;
        }

        return (bool) Arr::get($workShiftRecord, 'is_holiday', false);
    }

    private function checkIfOvernight(?array $workShiftRecord = []): bool
    {
        $isHoliday = $this->checkIfHoliday($workShiftRecord);

        if ($isHoliday) {
            return false;
        }

        return (bool) Arr::get($workShiftRecord, 'is_overnight', false);
    }

    private function findAttendanceDate(string $date, bool $isOvernight)
    {
        if (! $isOvernight) {
            return $date;
        }

        if (now()->timezone(config('config.system.timezone'))->toTimeString() >= '00:00:00' &&
            now()->timezone(config('config.system.timezone'))->toTimeString() <= '09:00:00') {
            return Carbon::parse($date)->subDay(1)->toDateString();
        }

        return $date;
    }
}
