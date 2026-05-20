<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Product extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'products';

    protected $fillable = [
        'name',
        'slug',
        'category',
        'sub_category',
        'price',
        'stock',
        'badge',
        'material',
        'image',
        'description',
        'details',
        'color_options',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'float',
            'stock' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function getDetailsAttribute($value): array
    {
        return $this->asArray($value);
    }

    public function getColorOptionsAttribute($value): array
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
