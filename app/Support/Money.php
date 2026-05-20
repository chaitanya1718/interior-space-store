<?php

namespace App\Support;

class Money
{
    public static function inr(float|int|null $amount): string
    {
        return '₹'.number_format((float) ($amount ?? 0), 0);
    }
}
