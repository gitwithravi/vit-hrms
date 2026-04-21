<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class TimesheetReportExport implements FromArray, WithHeadings, WithTitle
{
    public function __construct(protected array $rows) {}

    public function array(): array
    {
        return $this->rows;
    }

    public function headings(): array
    {
        return [
            'Employee Name',
            'Employee Code',
            'Date',
            'In Time',
            'Out Time',
            'Duration',
        ];
    }

    public function title(): string
    {
        return 'Timesheet Report';
    }
}
