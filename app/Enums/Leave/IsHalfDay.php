<?php

namespace App\Enums\Leave;

enum IsHalfDay: int
{
    case YES = 1;
    case NO = 0;

    public static function translation(): string
    {
        return 'leave.request.is_half_day.';
    }

    public static function labels(): array
    {
        return [
            self::YES->value => 'yes',
            self::NO->value => 'no',
        ];
    }

    public static function getOptions(): array
    {
        $options = [];

        foreach (self::cases() as $option) {
            $options[] = [
                'label' => trans(self::getLabel($option->value)),
                'value' => $option->value
            ];
        }

        return $options;
    }

    public static function getLabel($value): ?string
    {
        if (isset(self::labels()[$value])) {
            return trans(self::translation().self::labels()[$value]);
        }

        return $value;
    }

    public function positive(): bool
    {
        return self::YES->value === $this->value;
    }
}
