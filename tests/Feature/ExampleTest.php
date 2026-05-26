<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use Database\Seeders\DatabaseSeeder;
// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_storefront_pages_render_successfully(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('/')->assertOk()->assertSee('Satya Interiors');
        $this->get('/shop')->assertOk()->assertSee('Shop furniture');
        $this->get('/products/kensho-lounge-chair')->assertOk()->assertSee('Kensho Lounge Chair');
    }

    public function test_admin_dashboard_renders_successfully(): void
    {
        $this->seed(DatabaseSeeder::class);

        $admin = User::where('email', 'admin@example.com')->firstOrFail();

        $this->actingAs($admin)->get('/admin')->assertOk()->assertSee('Product Management');
    }

    public function test_out_of_stock_products_cannot_be_added_to_cart(): void
    {
        $this->seed(DatabaseSeeder::class);

        $product = Product::where('slug', 'kensho-lounge-chair')->firstOrFail();
        $product->update(['stock' => 0]);

        $this->get('/products/kensho-lounge-chair')
            ->assertOk()
            ->assertSee('Out of stock')
            ->assertDontSee('Add to bag')
            ->assertDontSee('name="quantity"', false);

        $this->post(route('cart.add', $product), ['quantity' => 1])
            ->assertRedirect(route('products.show', $product->slug))
            ->assertSessionHas('status', 'This item is currently out of stock.');

        $this->assertEmpty(session('cart', []));
    }

    public function test_customer_can_place_order_and_admin_can_create_product(): void
    {
        $this->seed(DatabaseSeeder::class);

        $customer = User::where('email', 'customer@example.com')->firstOrFail();
        $admin = User::where('email', 'admin@example.com')->firstOrFail();
        $product = Product::where('slug', 'kensho-lounge-chair')->firstOrFail();

        $this->actingAs($customer)
            ->withSession(['cart' => [$product->getKey().'|Standard' => 1]])
            ->post('/orders', [
                'phone' => '9999999999',
                'address' => '12 Design Street',
                'city' => 'Bengaluru',
                'postal_code' => '560001',
            ])
            ->assertRedirect();

        $this->actingAs($admin)
            ->post('/admin/products', [
                'name' => 'Test Console Table',
                'category' => 'Living Room',
                'sub_category' => 'Furniture',
                'price' => 500,
                'stock' => 5,
                'badge' => 'Test',
                'material' => 'Oak',
                'image' => 'https://example.com/console.jpg',
                'description' => 'A test product created by the admin workflow.',
                'details' => "Solid oak\nMade to order",
                'color_options' => "Warm Oak | #8d6e63\nBlack Ash | #303221",
                'is_active' => '1',
            ])
            ->assertRedirect(route('admin.products.index'));

        $this->assertTrue(Product::where('slug', 'test-console-table')->exists());
    }

    public function test_admin_and_customer_order_filters_render(): void
    {
        $this->seed(DatabaseSeeder::class);

        $admin = User::where('email', 'admin@example.com')->firstOrFail();
        $customer = User::where('email', 'customer@example.com')->firstOrFail();

        $this->actingAs($admin)
            ->get('/admin/products?q=chair&status=active&min_price=100&max_price=2000')
            ->assertOk()
            ->assertSee('Filter');

        $this->actingAs($admin)
            ->get('/admin/orders?q=bengaluru&status=placed&date_from=2026-01-01')
            ->assertOk()
            ->assertSee('Orders');

        $this->actingAs($customer)
            ->get('/orders?q=bengaluru&status=placed&date_from=2026-01-01')
            ->assertOk()
            ->assertSee('My orders');
    }
}
