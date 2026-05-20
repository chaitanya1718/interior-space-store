<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use App\Support\Catalog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin User', 'password' => 'password', 'is_admin' => true]
        );

        User::updateOrCreate(
            ['email' => 'chaitanyag1718@gmail.com'],
            ['name' => 'Chaitanya Admin', 'password' => 'Admin@Sat1718', 'is_admin' => true]
        );

        User::updateOrCreate(
            ['email' => 'customer@example.com'],
            ['name' => 'Customer User', 'password' => 'password', 'is_admin' => false]
        );

        foreach (Catalog::products() as $product) {
            Product::updateOrCreate(
                ['slug' => $product['slug']],
                $product + ['is_active' => true]
            );
        }
    }
}
