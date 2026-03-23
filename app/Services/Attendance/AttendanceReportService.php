<?php

namespace App\Services\Attendance;

use App\Contracts\ListGenerator;
use App\Http\Resources\Attendance\AttendanceResource;
use App\Models\Attendance\Attendance;
use App\Models\Attendance\Type as AttendanceType;
use App\Models\Employee\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class AttendanceReportService extends ListGenerator
{
    private ?Collection $employees = null;

    public function getHeaders(Request $request): array
    {
        $headers = [
            [
                'key' => 'employee',
                'label' => trans('employee.employee'),
                'print_label' => 'name',
                'visibility' => true,
            ],
        ];

        foreach ($request->attendance_types as $attendanceType) {
            array_push($headers, [
                'key' => 'type_'.Arr::get($attendanceType, 'code'),
                'label' => Arr::get($attendanceType, 'name'),
                'print_label' => 'summary._'.Arr::get($attendanceType, 'code'),
                'center_align' => true,
                'visibility' => true,
            ]);
        }

        array_push($headers, [
            'key' => 'type_late',
            'label' => trans('attendance.sub_categories.late'),
            'print_label' => 'summary._late',
            'center_align' => true,
            'visibility' => true,
        ]);

        array_push($headers, [
            'key' => 'type_early_leaving',
            'label' => trans('attendance.sub_categories.early_leaving'),
            'print_label' => 'summary._early_leaving',
            'center_align' => true,
            'visibility' => true,
        ]);

        array_push($headers, [
            'key' => 'type_overtime',
            'label' => trans('attendance.sub_categories.overtime'),
            'print_label' => 'summary._overtime',
            'center_align' => true,
            'visibility' => true,
        ]);

        return $headers;
    }

    public function list(Request $request): AnonymousResourceCollection
    {
        $request->validate([
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date',
        ]);

        $attendanceTypes = AttendanceType::query()->byTeam()->direct()->get();

        $attendanceTypeSummaries = $attendanceTypes->map(function ($attendanceType) {
            return [
                'code' => $attendanceType->code,
                'category' => $attendanceType->category,
                'name' => $attendanceType->name,
            ];
        });

        $attendanceTypeSummaries->push([
            'code' => 'L',
            'category' => 'leave',
            'name' => trans('leave.leave'),
        ]);

        $request->merge(['attendance_types' => $attendanceTypeSummaries]);

        $this->employees = $this->fetchEmployees($request);

        $query = Attendance::query()
            ->select('employee_id')
            ->whereIn('employee_id', $this->employees->pluck('id')->all())
            ->whereBetween('date', [$request->start_date, $request->end_date]);

        foreach ($attendanceTypes as $attendanceType) {
            $query->selectRaw('count(case when attendance_type_id = '.$attendanceType->id.' then 1 end) as '.$attendanceType->code);
        }

        $attendances = $query
            ->selectRaw("count(case when attendance_symbol = 'L' then 1 end) as L")
            ->selectRaw("count(case when JSON_EXTRACT(meta, '$.is_late') = true then 1 end) as late")
            ->selectRaw("sum(case when JSON_EXTRACT(meta, '$.is_late') = true then JSON_EXTRACT(meta, '$.late_duration') end) as total_late_duration")
            ->selectRaw("count(case when JSON_EXTRACT(meta, '$.is_early_leaving') = true then 1 end) as early_leaving")
            ->selectRaw("sum(case when JSON_EXTRACT(meta, '$.is_early_leaving') = true then JSON_EXTRACT(meta, '$.early_leaving_duration') end) as total_early_leaving_duration")
            ->selectRaw("count(case when JSON_EXTRACT(meta, '$.is_overtime') = true then 1 end) as overtime")
            ->selectRaw("sum(case when JSON_EXTRACT(meta, '$.is_overtime') = true then JSON_EXTRACT(meta, '$.overtime_duration') end) as total_overtime_duration")
            ->groupBy('employee_id')
            ->get();

        foreach ($this->employees as $employee) {
            $employeeSummary = $attendances->firstWhere('employee_id', $employee->id);

            $summary = [];
            $additionalSummary = [];

            foreach ($attendanceTypes as $attendanceType) {
                $code = $attendanceType->code;
                $summary['_'.$code] = $employeeSummary?->$code ?? 0;
            }
            $summary['_L'] = $employeeSummary?->L ?? 0;

            $summary['_late'] = $employeeSummary?->late ?? 0;
            $summary['_early_leaving'] = $employeeSummary?->early_leaving ?? 0;
            $summary['_overtime'] = $employeeSummary?->overtime ?? 0;

            $additionalSummary['total_late_duration'] = $employeeSummary?->total_late_duration ?? 0;
            $additionalSummary['total_early_leaving_duration'] = $employeeSummary?->total_early_leaving_duration ?? 0;
            $additionalSummary['total_overtime_duration'] = $employeeSummary?->total_overtime_duration ?? 0;

            $employee->list_summary = true;
            $employee->summary = $summary;
            $employee->additional_summary = $additionalSummary;
        }

        return AttendanceResource::collection($this->employees)
            ->additional(['headers' => $this->getHeaders($request)]);
    }

    public function getDayWiseRows(Request $request): array
    {
        $employees = $this->employees ?? $this->fetchEmployees($request);

        $attendances = Attendance::query()
            ->select('employee_id', 'date', 'attendance_symbol', 'attendance_types.code')
            ->leftJoin('attendance_types', 'attendances.attendance_type_id', '=', 'attendance_types.id')
            ->whereIn('employee_id', $employees->pluck('id')->all())
            ->whereBetween('date', [$request->start_date, $request->end_date])
            ->get();

        $dates = [];
        $current = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);
        while ($current <= $end) {
            $dates[] = $current->copy();
            $current->addDay();
        }

        $header = [trans('employee.employee')];
        foreach ($dates as $date) {
            $header[] = $date->format('d M Y');
        }

        $rows = [$header];

        foreach ($employees as $employee) {
            $employeeAttendances = $attendances->where('employee_id', $employee->id);
            $row = [$employee->name];

            foreach ($dates as $date) {
                $record = $employeeAttendances->firstWhere('date.value', $date->toDateString());

                if (! $record) {
                    $row[] = '';
                } elseif ($record->attendance_symbol === 'L') {
                    $row[] = 'L';
                } else {
                    $row[] = $record->code ?? '';
                }
            }

            $rows[] = $row;
        }

        return $rows;
    }

    private function fetchEmployees(Request $request): Collection
    {
        return Employee::query()
            ->detail()
            ->filterDfaAccessible()
            ->filterAccessible()
            ->where(fn ($q) => $q->whereNull('leaving_date')->orWhere('leaving_date', '>=', $request->start_date))
            ->orderBy('name')
            ->get();
    }
}
