<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Support\Catalog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminProductController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorizeAdmin();

        $products = Product::latest()->get();
        $products = $this->filterProducts($products, $request);

        return view('admin.products.index', [
            'products' => $products,
            'categories' => collect(Catalog::roomCategories())->merge(Product::pluck('category'))->unique()->sort()->values(),
            'filters' => $request->only(['q', 'category', 'status', 'min_price', 'max_price']),
        ]);
    }

    public function create(): View
    {
        $this->authorizeAdmin();

        return view('admin.products.form', [
            'product' => new Product(),
            'categories' => $this->categoryOptions(),
            'subCategories' => $this->subCategoryOptions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeAdmin();

        Product::create($this->validated($request));

        return redirect()->route('admin.products.index')->with('status', 'Product added.');
    }

    public function edit(Product $product): View
    {
        $this->authorizeAdmin();

        return view('admin.products.form', [
            'product' => $product,
            'categories' => $this->categoryOptions(),
            'subCategories' => $this->subCategoryOptions(),
        ]);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $this->authorizeAdmin();

        $product->update($this->validated($request, $product));

        return redirect()->route('admin.products.index')->with('status', 'Product updated.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->authorizeAdmin();
        $product->delete();

        return redirect()->route('admin.products.index')->with('status', 'Product deleted.');
    }

    public function orders(Request $request): View
    {
        $this->authorizeAdmin();

        $orders = $this->filterOrders(Order::latest()->get(), $request);

        return view('admin.orders', [
            'orders' => $orders,
            'statuses' => collect(['placed', 'packed', 'shipped', 'transit', 'delivered', 'cancelled']),
            'filters' => $request->only(['q', 'status', 'min_price', 'max_price', 'date_from', 'date_to']),
        ]);
    }

    private function authorizeAdmin(): void
    {
        abort_unless(auth()->user()?->is_admin, 403);
    }

    private function validated(Request $request, ?Product $product = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:160'],
            'category' => ['nullable', 'string', 'max:120'],
            'new_category' => ['nullable', 'string', 'max:120'],
            'sub_category' => ['nullable', 'string', 'max:120'],
            'new_sub_category' => ['nullable', 'string', 'max:120'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'badge' => ['nullable', 'string', 'max:60'],
            'material' => ['required', 'string', 'max:160'],
            'image' => ['required', 'url', 'max:2000'],
            'description' => ['required', 'string', 'max:800'],
            'details' => ['nullable', 'string', 'max:1000'],
            'color_options' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['category'] = trim($data['new_category'] ?? '') ?: ($data['category'] ?? null);
        $data['sub_category'] = trim($data['new_sub_category'] ?? '') ?: ($data['sub_category'] ?? null);
        unset($data['new_category'], $data['new_sub_category']);

        abort_if(blank($data['category']), 422, 'Select or add a room category.');
        abort_if(blank($data['sub_category']), 422, 'Select or add a product sub-category.');

        $data['price'] = (float) $data['price'];
        $data['stock'] = (int) $data['stock'];

        $data['slug'] = Str::slug($data['name']);
        $slugExists = Product::where('slug', $data['slug'])
            ->when($product?->exists, fn ($query) => $query->where('_id', '!=', $product->getKey()))
            ->exists();

        if ($slugExists) {
            $data['slug'] .= '-'.Str::lower(Str::random(5));
        }

        $data['details'] = collect(preg_split('/\r\n|\r|\n/', $data['details'] ?? ''))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();
        $data['color_options'] = collect(preg_split('/\r\n|\r|\n/', $data['color_options'] ?? ''))
            ->map(function ($line) {
                [$name, $hex, $image] = array_pad(array_map('trim', explode('|', $line, 3)), 3, null);

                return $name && $hex ? array_filter(['name' => $name, 'hex' => $hex, 'image' => $image]) : null;
            })
            ->filter()
            ->values()
            ->all();
        $data['badge'] = $data['badge'] ?: 'Ready';
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }

    private function categoryOptions()
    {
        return collect(Catalog::roomCategories())->merge(Product::pluck('category'))->unique()->sort()->values();
    }

    private function subCategoryOptions()
    {
        return collect(Catalog::subCategories())->merge(Product::pluck('sub_category'))->unique()->filter()->sort()->values();
    }

    private function filterProducts(Collection $products, Request $request): Collection
    {
        return $products
            ->when($request->filled('q'), function (Collection $products) use ($request) {
                $term = Str::lower($request->string('q')->toString());

                return $products->filter(fn (Product $product) => str_contains(Str::lower($product->name), $term));
            })
            ->when($request->filled('category'), fn (Collection $products) => $products->where('category', $request->category))
            ->when($request->filled('status'), function (Collection $products) use ($request) {
                return $products->where('is_active', $request->status === 'active');
            })
            ->when($request->filled('min_price'), fn (Collection $products) => $products->filter(fn (Product $product) => $product->price >= (float) $request->min_price))
            ->when($request->filled('max_price'), fn (Collection $products) => $products->filter(fn (Product $product) => $product->price <= (float) $request->max_price))
            ->values();
    }

    private function filterOrders(Collection $orders, Request $request): Collection
    {
        return $orders
            ->when($request->filled('q'), function (Collection $orders) use ($request) {
                $term = Str::lower($request->string('q')->toString());

                return $orders->filter(function (Order $order) use ($term) {
                    $customer = implode(' ', $order->customer ?? []);
                    $address = implode(' ', $order->shipping_address ?? []);
                    $products = collect($order->items ?? [])->pluck('name')->implode(' ');
                    $haystack = Str::lower($customer.' '.$address.' '.$products);

                    return str_contains($haystack, $term);
                });
            })
            ->when($request->filled('status'), fn (Collection $orders) => $orders->where('status', $request->status))
            ->when($request->filled('min_price'), fn (Collection $orders) => $orders->filter(fn (Order $order) => $order->subtotal >= (float) $request->min_price))
            ->when($request->filled('max_price'), fn (Collection $orders) => $orders->filter(fn (Order $order) => $order->subtotal <= (float) $request->max_price))
            ->when($request->filled('date_from'), fn (Collection $orders) => $orders->filter(fn (Order $order) => $order->created_at?->gte(Carbon::parse($request->date_from)->startOfDay())))
            ->when($request->filled('date_to'), fn (Collection $orders) => $orders->filter(fn (Order $order) => $order->created_at?->lte(Carbon::parse($request->date_to)->endOfDay())))
            ->values();
    }
}
