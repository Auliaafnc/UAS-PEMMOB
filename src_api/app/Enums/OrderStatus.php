<?php

namespace App\Enums;

enum OrderStatus: string
{
    case SO = 'Sales Order';
    case PO = 'Purchase Order';
    case CANCEL = 'Cancel Order';

    // Optional: Method to get labels for each status
    public function label(): string
    {
        return match ($this) {
            self::SO => 'Sales Order',
            self::PO => 'Purchase Order',
            self::CANCEL => 'Cancel Order',
        };
    }

    // Static method to return all values as options
    public static function options(): array
    {
        return array_column(self::cases(), 'value', 'value');
    }
}
