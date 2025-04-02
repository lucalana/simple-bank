<?php

namespace App\Enums;

enum TransactionType: string
{
    case Deposit = 'deposito';
    case Transfer = 'tranferencia';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
