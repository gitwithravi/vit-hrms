<?php

namespace App\Http\Controllers\Attendance;

use App\Exports\TimesheetReportExport;
use App\Http\Controllers\Controller;
use App\Models\Attendance\Timesheet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TimesheetReportController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $timesheets = Timesheet::query()
            ->with(['employee' => fn ($q) => $q->summary()])
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date')
            ->get()
            ->sortBy(fn ($t) => ($t->employee?->name ?? '').'-'.$t->date->value)
            ->values();

        $rows = $timesheets->map(function (Timesheet $timesheet) {
            $inAt = $timesheet->in_at->value ?? null;
            $outAt = $timesheet->out_at->value ?? null;

            if (empty($inAt) || empty($outAt)) {
                $duration = 'One Entry Missing';
            } else {
                $duration = Carbon::parse($outAt)->diff(Carbon::parse($inAt))->format('%H:%I:%S');
            }

            return [
                $timesheet->employee?->name ?? '-',
                $timesheet->employee?->code_number ?? '-',
                $timesheet->date->value ? Carbon::parse($timesheet->date->value)->toDateString() : '-',
                $inAt ? Carbon::parse($inAt)->format('H:i:s') : '-',
                $outAt ? Carbon::parse($outAt)->format('H:i:s') : '-',
                $duration,
            ];
        })->all();

        $filename = 'timesheet-report-'.$startDate.'-to-'.$endDate.'.xlsx';

        return Excel::download(new TimesheetReportExport($rows), $filename);
    }
}
