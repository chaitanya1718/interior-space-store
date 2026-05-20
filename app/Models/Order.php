<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Order extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'orders';

    protected $fillable = [
        'user_id',
        'customer',
        'items',
        'subtotal',
        'status',
        'payment',
        'shipping_address',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'float',
        ];
    }

    public function getCustomerAttribute($value): array
    {
        return $this->asArray($value);
    }

    public function getItemsAttribute($value): array
    {
        return $this->asArray($value);
    }

    public function getShippingAddressAttribute($value): array
    {
        return $this->asArray($value);
    }

    public function getPaymentAttribute($value): array
    {
        return $this->asArray($value);
    }

    private function asArray($value): array
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
