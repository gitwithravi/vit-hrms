<?php

namespace App\Services\Attendance;

use App\Concerns\SubordinateAccess;
use App\Enums\Leave\RequestStatus as LeaveRequestStatus;
use App\Models\Attendance\Attendance;
use App\Models\Attendance\Type as AttendanceType;
use App\Models\Calendar\Holiday;
use App\Models\Leave\Allocation as LeaveAllocation;
use App\Models\Leave\AllocationRecord as LeaveAllocationRecord;
use App\Models\Leave\Request as LeaveRequest;
use App\Models\Leave\RequestRecord as LeaveRequestRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class HolidaySyncService
{
    use SubordinateAccess;

    public function sync(Request $request): int
    {
        $request->validate([
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date',
            'attendance_type_uuid' => 'required|string',
        ]);

        $attendanceType = AttendanceType::byTeam()
            ->direct()
            ->where('uuid', $request->attendance_type_uuid)
            ->first();

        if (! $attendanceType) {
            throw ValidationException::withMessages(['attendance_type_uuid' => trans('general.errors.invalid_input')]);
        }

        $holidays = Holiday::query()
            ->byTeam()
            ->betweenPeriod($request->start_date, $request->end_date)
            ->get();

        if ($holidays->isEmpty()) {
            throw ValidationException::withMessages(['message' => 'No holidays found for the selected date range.']);
        }

        $holidayDates = collect();
        foreach ($holidays as $holiday) {
            $date = Carbon::parse($holiday->start_date->value);
            $end = Carbon::parse($holiday->end_date->value);

            while ($date->toDateString() <= $end->toDateString()) {
                $dateString = $date->toDateString();
                if ($dateString >= $request->start_date && $dateString <= $request->end_date) {
                    $holidayDates->push($dateString);
                }
                $date->addDay();
            }
        }

        $holidayDates = $holidayDates->unique()->values();

        if ($holidayDates->isEmpty()) {
            return 0;
        }

        $employeeIds = $this->getAccessibleEmployeeIds();

        if (empty($employeeIds)) {
            throw ValidationException::withMessages(['message' => 'No accessible employees found.']);
        }

        return DB::transaction(function () use ($holidayDates, $employeeIds, $attendanceType) {
            $cancelled = $this->cancelConflictingLeaves($holidayDates, $employeeIds);

            foreach ($holidayDates as $dateString) {
                foreach ($employeeIds as $employeeId) {
                    Attendance::updateOrCreate(
                        [
                            'employee_id' => $employeeId,
                            'date' => $dateString,
                        ],
                        [
                            'attendance_type_id' => $attendanceType->id,
                            'attendance_symbol' => null,
                            'is_time_based' => false,
                        ]
                    );
                }
            }

            return $cancelled;
        });
    }

    private function cancelConflictingLeaves(Collection $holidayDates, array $employeeIds): int
    {
        $minDate = $holidayDates->min();
        $maxDate = $holidayDates->max();

        $leaveRequests = LeaveRequest::whereIn('employee_id', $employeeIds)
            ->where('status', LeaveRequestStatus::APPROVED)
            ->where('start_date', '<=', $maxDate)
            ->where('end_date', '>=', $minDate)
            ->get();

        $leaveRequests = $leaveRequests->filter(function ($leaveRequest) use ($holidayDates) {
            $start = $leaveRequest->start_date->value;
            $end = $leaveRequest->end_date->value;

            return $holidayDates->contains(function ($date) use ($start, $end) {
                return $date >= $start && $date <= $end;
            });
        });

        $cancelled = 0;

        foreach ($leaveRequests as $leaveRequest) {
            $isHalfDay = $leaveRequest->is_half_day?->positive();
            if ($isHalfDay) {
                $duration = 0.5;
            } else {
                $duration = Carbon::parse($leaveRequest->start_date->value)
                    ->diffInDays(Carbon::parse($leaveRequest->end_date->value)) + 1;
            }

            $allocation = LeaveAllocation::where('employee_id', $leaveRequest->employee_id)
                ->whereDate('start_date', '<=', $leaveRequest->start_date->value)
                ->whereDate('end_date', '>=', $leaveRequest->start_date->value)
                ->first();

            if ($allocation) {
                LeaveAllocationRecord::where('leave_allocation_id', $allocation->id)
                    ->where('leave_type_id', $leaveRequest->leave_type_id)
                    ->decrement('used', $duration);
            }

            $leaveRequest->update(['status' => LeaveRequestStatus::REJECTED]);

            LeaveRequestRecord::create([
                'leave_request_id' => $leaveRequest->id,
                'status' => LeaveRequestStatus::REJECTED->value,
                'comment' => 'Cancelled due to holiday sync.',
            ]);

            $cancelled++;
        }

        return $cancelled;
    }
}
