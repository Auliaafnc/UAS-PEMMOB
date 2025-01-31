<?php

namespace App\Enums;

enum EmployeeStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case ONLEAVE = 'on_leave';
    case TERMINATED = 'terminated';

    // Optional: Method to get labels for each status
    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'active',
            self::INACTIVE => 'inactive',
            self::ONLEAVE => 'on_leave',
            self::TERMINATED => 'terminated',
        };
    }

    // Static method to return all values as options
    public static function options(): array
    {
        return array_column(self::cases(), 'value', 'value');
    }
}
