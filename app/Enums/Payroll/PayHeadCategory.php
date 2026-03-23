<?php

namespace App\Enums\Payroll;

use App\Concerns\HasEnum;
use App\Contracts\HasColor;

enum PayHeadCategory: string implements HasColor
{
    use HasEnum;

    case EARNING = 'earning';
    case DEDUCTION = 'deduction';

    public static function translation(): string
    {
        return 'payroll.pay_head.categories.';
    }

    public function color(): string
    {
        return match ($this) {
            self::EARNING => 'success',
            self::DEDUCTION => 'danger',
        };
    }
}
