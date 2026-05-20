<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class CustomOrder extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'custom_orders';

    protected $fillable = [
        'user_id',
        'customer',
        'room',
        'needs',
        'budget',
        'preferred_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'budget' => 'float',
            'preferred_date' => 'date',
        ];
    }

    public function getCustomerAttribute($value): array
    {
        if (is_array($value)) {
            return $value;
        }

        if (is_string($value)) {
            $decoded = json_decode($value, true);

            return is_array($decoded) ? $decoded : [];
        }

        return [];
    }
}
