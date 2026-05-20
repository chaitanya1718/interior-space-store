<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Support\Catalog;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\View\View;

class StorefrontController extends Controller
{
    public function home(): View
    {
        $activeProducts = Product::where('is_active', true)->latest()->get();

        return view('store.home', [
            'featured' => $activeProducts->take(8),
            'homeNeeds' => $activeProducts->filter(fn (Product $product) => in_array($product->sub_category, ['Furniture', 'Lighting', 'Decor', 'Storage', 'Textiles']))->take(8)->values(),
            'categories' => Catalog::categories(),
            'productCategories' => Catalog::productCategories(),
        ]);
    }

    public function shop(Request $request): View
    {
        $products = $this->filterProducts(Product::where('is_active', true)->latest()->get(), $request);

        return view('store.shop', [
            'products' => $products,
            'categories' => $this->categoryOptions(),
            'subCategories' => $this->subCategoryOptions(),
            'filters' => $request->only(['q', 'category', 'sub_category']),
            'heading' => $request->filled('q') ? 'Search results for "'.$request->string('q')->toString().'"' : 'Shop furniture and interior products',
        ]);
    }

    public function services(): View
    {
        return view('store.services');
    }

    public function category(string $category, Request $request): View
    {
        $categoryName = Catalog::categoryFromSlug($category) ?? str($category)->replace('-', ' ')->title()->toString();
        $request->merge(['category' => $categoryName]);
        $products = $this->filterProducts(Product::where('is_active', true)->latest()->get(), $request);

        return view('store.shop', [
            'products' => $products,
            'categories' => $this->categoryOptions(),
            'subCategories' => $this->subCategoryOptions(),
            'filters' => $request->only(['q', 'category', 'sub_category']),
            'heading' => $categoryName.' products',
            'activeCategory' => $categoryName,
        ]);
    }

    public function product(string $slug): View
    {
        $product = Product::where('slug', $slug)->where('is_active', true)->firstOrFail();

        return view('store.product', [
            'product' => $product,
            'related' => Product::where('slug', '!=', $product->slug)->where('is_active', true)->take(3)->get(),
        ]);
    }

    private function filterProducts(Collection $products, Request $request): Collection
    {
        return $products
            ->when($request->filled('q'), function (Collection $products) use ($request) {
                $term = Str::lower($request->string('q')->toString());

                return $products->filter(function (Product $product) use ($term) {
                    $haystack = Str::lower(implode(' ', [
                        $product->name,
                        $product->category,
                        $product->sub_category,
                        $product->material,
                        $product->description,
                    ]));

                    return str_contains($haystack, $term);
                });
            })
            ->when($request->filled('category'), fn (Collection $products) => $products->where('category', $request->category))
            ->when($request->filled('sub_category'), fn (Collection $products) => $products->where('sub_category', $request->sub_category))
            ->values();
    }

    private function categoryOptions(): Collection
    {
        return collect(Catalog::roomCategories())
            ->merge(Product::where('is_active', true)->pluck('category'))
            ->filter()
            ->unique()
            ->values();
    }

    private function subCategoryOptions(): Collection
    {
        return collect(Catalog::subCategories())
            ->merge(Product::where('is_active', true)->pluck('sub_category'))
            ->filter()
            ->unique()
            ->values();
    }
}
