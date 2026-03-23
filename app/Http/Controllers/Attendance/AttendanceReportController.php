<?php

namespace App\Http\Controllers\Attendance;

use App\Exports\AttendanceReportExport;
use App\Http\Controllers\Controller;
use App\Services\Attendance\AttendanceReportService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceReportController extends Controller
{
    public function __invoke(Request $request, AttendanceReportService $service)
    {
        $summaryList = $service->list($request);
        $summaryItems = $service->listArray($summaryList);
        $summaryData = $service->getAdditionalData($summaryList);
        $summaryRows = $service->prepareForExport($summaryData, $summaryItems);
        unset($summaryRows['meta']);

        $dayWiseRows = $service->getDayWiseRows($request);

        $filename = 'attendance-report-'.$request->start_date.'-to-'.$request->end_date;

        return Excel::download(new AttendanceReportExport($summaryRows, $dayWiseRows), $filename.'.xlsx');
    }
}
