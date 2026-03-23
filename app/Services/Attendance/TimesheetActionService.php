<?php

namespace App\Services\Attendance;

use App\Concerns\SubordinateAccess;
use App\Http\Resources\Attendance\TimesheetResource;
use App\Models\Attendance\Attendance;
use App\Models\Attendance\Timesheet;
use App\Models\Employee\Employee;
use App\Models\Employee\WorkShift as EmployeeWorkShift;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TimesheetActionService
{
    use SubordinateAccess;

    const CLOCK_IN = 'in';

    const CLOCK_OUT = 'out';

    private function isEmployeeClockInOutAllowed()
    {
        return config('config.attendance.allow_employee_clock_in_out');
    }

    private function isEmployeeGeolocationEnabled()
    {
        return config('config.attendance.enable_geolocation_timesheet');
    }

    private function findEmployeeWorkShift(Employee $employee): ?EmployeeWorkShift
    {
        return EmployeeWorkShift::query()
            ->select('work_shifts.records', 'employee_work_shifts.employee_id', 'employee_work_shifts.work_shift_id')
            ->join('work_shifts', function ($join) {
                $join->on('employee_work_shifts.work_shift_id', '=', 'work_shifts.id');
            })
            ->whereEmployeeId($employee->id)
            ->where('start_date', '<=', today()->toDateString())
            ->where('end_date', '>=', today()->toDateString())
            ->first();
    }

    private function findEmployeeWorkShiftOrFail(Employee $employee): EmployeeWorkShift
    {
        $employeeWorkShift = $this->findEmployeeWorkShift($employee);

        if (! $employeeWorkShift) {
            throw ValidationException::withMessages(['message' => trans('attendance.timesheet.could_not_perform_without_work_shift')]);
        }

        return $employeeWorkShift;
    }

    private function ensureAttendanceNotSynched(Request $request, Employee $employee)
    {
        $attendanceExists = Attendance::query()
            ->where('date', today()->toDateString())
            ->whereEmployeeId($employee->id)
            ->whereIsTimeBased(1)
            ->exists();

        if ($attendanceExists) {
            throw ValidationException::withMessages(['message' => trans('attendance.timesheet.could_not_perform_if_attendance_synched')]);
        }
    }

    private function validateInput(Request $request, ?Timesheet $timesheet)
    {
        if (! $timesheet && $request->type == self::CLOCK_OUT) {
            throw ValidationException::withMessages(['message' => trans('general.errors.invalid_input')]);
        }

        if ($timesheet && ! $timesheet->out_at && $request->type == self::CLOCK_IN) {
            throw ValidationException::withMessages(['message' => trans('general.errors.invalid_input')]);
        }
    }

    public function check(Request $request): array
    {
        if (! $this->isEmployeeClockInOutAllowed()) {
            return [
                'has_timesheet' => false,
            ];
        }

        $employee = Employee::auth()->first();

        if (! $employee) {
            return [
                'has_timesheet' => false,
            ];
        }

        $employeeWorkShift = $this->findEmployeeWorkShift($employee);

        if (! $employeeWorkShift) {
            return [
                'has_timesheet' => false,
            ];
        }

        $type = self::CLOCK_IN;

        $timesheets = Timesheet::query()
            ->whereEmployeeId($employee->id)
            ->where('date', today()->toDateString())
            ->orderBy('in_at', 'desc')
            ->get();

        if (is_null($timesheets->first())) {
            $type = self::CLOCK_IN;
        } elseif (empty($timesheets->first()?->out_at?->value)) {
            $type = self::CLOCK_OUT;
        }

        return [
            'has_timesheet' => true,
            'timesheet' => [
                'clock_in' => $type == self::CLOCK_IN ? true : false,
                'clock_out' => $type == self::CLOCK_OUT ? true : false,
            ],
            'timesheets' => TimesheetResource::collection($timesheets),
        ];
    }

    private function validateGeolocation(Request $request): float
    {
        if (! $this->isEmployeeGeolocationEnabled()) {
            return 0;
        }

        $geolocationLatitude = config('config.attendance.geolocation_latitude');
        $geolocationLongitude = config('config.attendance.geolocation_longitude');
        $geolocationRadius = config('config.attendance.geolocation_radius');

        $request->validate([
            'location.latitude' => 'required|numeric',
            'location.longitude' => 'required|numeric',
        ]);

        $earthRadius = 6371;

        $lat1Rad = deg2rad($request->input('location.latitude'));
        $lat2Rad = deg2rad($geolocationLatitude);
        $lon1Rad = deg2rad($request->input('location.longitude'));
        $lon2Rad = deg2rad($geolocationLongitude);

        $latDiff = $lat2Rad - $lat1Rad;
        $lonDiff = $lon2Rad - $lon1Rad;

        $a = sin($latDiff / 2) ** 2 + cos($lat1Rad) * cos($lat2Rad) * sin($lonDiff / 2) ** 2;
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = round($earthRadius * $c * 1000, 2);

        if ($distance > $geolocationRadius) {
            throw ValidationException::withMessages(['message' => trans('attendance.timesheet.could_not_mark_attendance_outside_geolocation', ['distance' => $distance])]);
        }

        return $distance;
    }

    public function clock(Request $request)
    {
        if (! $this->isEmployeeClockInOutAllowed()) {
            throw ValidationException::withMessages(['message' => trans('general.errors.invalid_action')]);
        }

        $distance = $this->validateGeolocation($request);

        $employee = Employee::auth()->first();

        $employeeWorkShift = $this->findEmployeeWorkShiftOrFail($employee);

        $this->ensureAttendanceNotSynched($request, $employee);

        $timesheet = Timesheet::query()
            ->whereEmployeeId($employee->id)
            ->where('date', today()->toDateString())
            ->orderBy('in_at', 'desc')
            ->first();

        $this->validateInput($request, $timesheet);

        if ($timesheet && ! $timesheet->out_at->value) {
            $timesheet->out_at = now()->toDateTimeString();
            $timesheet->setMeta([
                'out' => [
                    'self' => true,
                    'latitude' => $request->input('location.latitude'),
                    'longitude' => $request->input('location.longitude'),
                    'distance' => $distance ?? null,
                    'ip' => $request->ip(),
                ],
            ]);
            $timesheet->save();
        } else {
            $timesheet = Timesheet::forceCreate([
                'employee_id' => $employee->id,
                'work_shift_id' => $employeeWorkShift->work_shift_id,
                'date' => today()->toDateString(),
                'in_at' => now()->toDateTimeString(),
                'meta' => [
                    'in' => [
                        'self' => true,
                        'latitude' => $request->input('location.latitude'),
                        'longitude' => $request->input('location.longitude'),
                        'distance' => $distance ?? null,
                        'ip' => $request->ip(),
                    ],
                ],
            ]);
        }

        $timesheets = Timesheet::query()
            ->whereEmployeeId($employee->id)
            ->where('date', today()->toDateString())
            ->orderBy('in_at', 'desc')
            ->get();

        return [
            'has_timesheet' => true,
            'timesheet' => TimesheetResource::make($timesheet),
            'timesheets' => TimesheetResource::collection($timesheets),
        ];
    }
}
