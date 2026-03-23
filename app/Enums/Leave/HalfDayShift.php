<?php

namespace App\Enums\Leave;

enum HalfDayShift: string
{
    case FN = 'FN';
    case AN = 'AN';
    case NA = 'NA';

    public static function translation(): string
    {
        return 'leave.request.half_day_shift.';
    }

    public static function getOptions(): array
    {
        $options = [];

        foreach (self::cases() as $option) {
            if (self::NA!=$option)
            $options[] = [
                'label' => trans(self::translation().$option->value),
                'value' => $option->value
            ];
        }

        return $options;
    }
}
