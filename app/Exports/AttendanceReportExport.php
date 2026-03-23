<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;

class AttendanceReportExport implements WithMultipleSheets
{
    public function __construct(
        protected array $summaryRows,
        protected array $dayWiseRows,
    ) {}

    public function sheets(): array
    {
        $summaryRows = $this->summaryRows;
        $dayWiseRows = $this->dayWiseRows;

        return [
            new class($summaryRows) implements FromArray, WithTitle {
                public function __construct(protected array $rows) {}

                public function title(): string
                {
                    return 'Summary';
                }

                public function array(): array
                {
                    return $this->rows;
                }
            },
            new class($dayWiseRows) implements FromArray, WithTitle {
                public function __construct(protected array $rows) {}

                public function title(): string
                {
                    return 'Day Wise';
                }

                public function array(): array
                {
                    return $this->rows;
                }
            },
        ];
    }
}
