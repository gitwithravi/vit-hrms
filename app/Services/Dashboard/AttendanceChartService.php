<?php

namespace App\Services\Dashboard;

use App\Concerns\SubordinateAccess;
use App\Helpers\CalHelper;
use App\Models\Attendance\Attendance;
use App\Models\Attendance\Type as AttendanceType;
use Illuminate\Http\Request;

class AttendanceChartService
{
    use SubordinateAccess;

    public function getData(Request $request): array
    {
        $accessibleEmployeeIds = $this->getAccessibleEmployeeIds();

        $start = today()->subWeeks(2)->toDateString();
        $end = today()->toDateString();

        $attendanceTypes = AttendanceType::byTeam()->direct()->get();

        $query = Attendance::query()
            ->select('date')
            ->whereIn('employee_id', $accessibleEmployeeIds)
            ->whereBetween('date', [$start, $end]);

        $codes = [];
        foreach ($attendanceTypes as $attendanceType) {
            $codes[] = $attendanceType->code;
            $query->selectRaw('count(case when attendance_type_id = '.$attendanceType->id.' then 1 end) as '.$attendanceType->code);
        }

        $attendances = $query
            ->selectRaw("count(case when attendance_symbol = 'L' then 1 end) as L")
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = [];
        $items = collect([]);

        $current = today()->subWeeks(2);
        while ($current->toDateString() <= $end) {
            $dateStr = $current->toDateString();
            $labels[] = CalHelper::showDate($dateStr);

            $hasAttendance = $attendances->firstWhere('date.value', $dateStr);

            if (! $hasAttendance) {
                $attendance = ['date' => $dateStr, 'L' => 0];
                foreach ($codes as $code) {
                    $attendance[$code] = 0;
                }
                $items->push($attendance);
            } else {
                $items->push($hasAttendance);
            }

            $current->addDay();
        }

        $datasets = [];

        foreach ($codes as $code) {
            $attendanceType = $attendanceTypes->firstWhere('code', $code);
            $datasets[] = [
                'label' => $attendanceType->name,
                'data' => $items->pluck($code)->map(fn ($v) => (int) $v)->all(),
                'backgroundColor' => $attendanceType->color,
                'borderColor' => $attendanceType->color,
                'borderWidth' => 1,
            ];
        }

        $datasets[] = [
            'label' => trans('attendance.categories.leave'),
            'data' => $items->pluck('L')->map(fn ($v) => (int) $v)->all(),
            'backgroundColor' => '#D82161',
            'borderColor' => '#D82161',
            'borderWidth' => 1,
        ];

        return [
            'labels' => $labels,
            'datasets' => $datasets,
        ];
    }
}
