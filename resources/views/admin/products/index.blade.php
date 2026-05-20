@extends('layouts.admin')

@section('title', 'Admin Products | Satya Interiors')

@section('content')
    <section class="section-head split">
        <div><p class="eyebrow">Admin</p><h1>Products</h1></div>
        <a class="button" href="{{ route('admin.products.create') }}">Add Product</a>
    </section>
    @if(session('status'))<p class="notice">{{ session('status') }}</p>@endif

    <form method="GET" action="{{ route('admin.products.index') }}" class="filter-bar">
        <label>Product name <input name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Search product"></label>
        <label>Category
            <select name="category">
                <option value="">All categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category }}" @selected(($filters['category'] ?? '') === $category)>{{ $category }}</option>
                @endforeach
            </select>
        </label>
        <label>Status
            <select name="status">
                <option value="">All status</option>
                <option value="active" @selected(($filters['status'] ?? '') === 'active')>Active</option>
                <option value="hidden" @selected(($filters['status'] ?? '') === 'hidden')>Hidden</option>
            </select>
        </label>
        <label>Min price <input name="min_price" type="number" min="0" step="0.01" value="{{ $filters['min_price'] ?? '' }}"></label>
        <label>Max price <input name="max_price" type="number" min="0" step="0.01" value="{{ $filters['max_price'] ?? '' }}"></label>
        <div class="filter-actions">
            <button class="button" type="submit">Filter</button>
            <a class="button ghost" href="{{ route('admin.products.index') }}">Clear</a>
        </div>
    </form>

    <section class="admin-panel">
        <div class="table-wrap">
            <table class="admin-table products-table">
                <thead><tr><th>Product</th><th>Category</th><th>Stock</th><th>Price</th><th>Status</th><th class="actions-head">Actions</th></tr></thead>
                <tbody>
                @forelse($products as $product)
                    <tr>
                        <td class="product-cell">
                            <div class="product-cell-inner">
                                <img src="{{ $product->image }}" alt="">
                                <span>{{ $product->name }}</span>
                            </div>
                        </td>
                        <td>{{ $product->category }}<br><span class="muted-cell">{{ $product->sub_category }}</span></td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ \App\Support\Money::inr($product->price) }}</td>
                        <td><span class="status">{{ $product->is_active ? 'Active' : 'Hidden' }}</span></td>
                        <td class="table-actions">
                            <a class="text-link" href="{{ route('admin.products.edit', $product) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}">
                                @csrf @method('DELETE')
                                <button class="link-button" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="empty-cell">No products match your filters.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
