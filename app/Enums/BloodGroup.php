<?php

namespace App\Enums;

use App\Concerns\HasEnum;

enum BloodGroup: string
{
    use HasEnum;

    case O_POSITIVE = 'o_positive';
    case O_NEGATIVE = 'o_negative';
    case A_POSITIVE = 'a_positive';
    case A_NEGATIVE = 'a_negative';
    case B_POSITIVE = 'b_positive';
    case B_NEGATIVE = 'b_negative';
    case AB_POSITIVE = 'ab_positive';
    case AB_NEGATIVE = 'ab_negative';

    public static function translation(): string
    {
        return 'list.blood_groups.';
    }
}
