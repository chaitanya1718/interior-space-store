@extends('layouts.store')

@section('title', 'Shop | Satya Interiors')

@section('content')
<main class="page">
    <section class="shop-heading">
        <p class="eyebrow">{{ isset($activeCategory) ? 'Room catalog' : 'Catalog' }}</p>
        <h1>{{ $heading ?? 'Shop furniture and interior products' }}</h1>
        <p>
            @if(($filters['q'] ?? null) || ($filters['category'] ?? null) || ($filters['sub_category'] ?? null))
                Showing {{ $products->count() }} matching {{ \Illuminate\Support\Str::plural('piece', $products->count()) }}.
            @else
                Browse refined pieces for living rooms, bedrooms, dining spaces, offices, lighting, and textiles.
            @endif
        </p>
    </section>

    <section class="shop-layout">
        <aside class="filters" aria-label="Product filters">
            <h2>Filters</h2>
            <form method="GET" action="{{ route('shop') }}" class="shop-filter-form" data-auto-filter>
            <label>Search products<input name="q" type="search" placeholder="Chair, table, rug" value="{{ $filters['q'] ?? '' }}"></label>
            <div>
                <h3>Category</h3>
                <label class="check"><input name="category" type="radio" value="" @checked(blank($filters['category'] ?? null))> All rooms</label>
                @foreach($categories as $category)
                    <label class="check"><input name="category" type="radio" value="{{ $category }}" @checked(($filters['category'] ?? '') === $category)> {{ $category }}</label>
                @endforeach
            </div>
            <div>
                <h3>Type</h3>
                <label class="check"><input name="sub_category" type="radio" value="" @checked(blank($filters['sub_category'] ?? null))> All types</label>
                @foreach($subCategories as $subCategory)
                    <label class="check"><input name="sub_category" type="radio" value="{{ $subCategory }}" @checked(($filters['sub_category'] ?? '') === $subCategory)> {{ $subCategory }}</label>
                @endforeach
            </div>
            <div class="filter-actions">
                <button class="button" type="submit">Apply</button>
                <a class="text-link" href="{{ route('shop') }}">Clear</a>
            </div>
            </form>
        </aside>

        <div class="product-grid shop-products">
            @forelse($products as $product)
                @include('store.partials.product-card', ['product' => $product])
            @empty
                <div class="empty-results">
                    <h2>No products found</h2>
                    <p>Try a different room, product type, or search term.</p>
                    <a class="button ghost" href="{{ route('shop') }}">View all products</a>
                </div>
            @endforelse
        </div>
    </section>
</main>
@endsection
