@extends('layouts.admin')

@section('title', 'Admin Dashboard | Satya Interiors')

@section('content')
    <header class="admin-topbar">
        <div><p class="eyebrow">Operations</p><h2>Admin Dashboard</h2></div>
        <a class="button" href="{{ route('admin.products.create') }}"><i data-lucide="plus"></i> Add Product</a>
    </header>

    <section class="stat-grid">
        <div><span>Total Products</span><strong>{{ $stats['products'] }}</strong></div>
        <div><span>Units in Stock</span><strong>{{ $stats['stock'] }}</strong></div>
        <div><span>Orders</span><strong>{{ $stats['orders'] }}</strong></div>
        <div><span>Delivered Revenue</span><strong>{{ \App\Support\Money::inr($stats['revenue']) }}</strong></div>
    </section>

    <section class="admin-panel revenue-panel">
        <div class="section-head split">
            <div><p class="eyebrow">Delivered revenue</p><h2>Last 7 days</h2></div>
            <strong>{{ \App\Support\Money::inr($stats['revenue']) }} delivered total</strong>
        </div>
        <div class="revenue-chart" aria-label="Revenue generated over the last 7 days">
            @foreach($revenueChart as $point)
                <div class="revenue-bar">
                    <span style="height: {{ max(8, ($point['total'] / $maxRevenue) * 100) }}%"></span>
                    <small>{{ $point['label'] }}</small>
                    <em>{{ \App\Support\Money::inr($point['total']) }}</em>
                </div>
            @endforeach
        </div>
    </section>

    <section class="admin-panel">
        <div class="section-head split">
            <div><p class="eyebrow">Inventory</p><h2>Product Management</h2></div>
            <a class="text-link" href="{{ route('admin.products.index') }}">Manage products</a>
        </div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>Product</th><th>Category</th><th>Stock</th><th>Price</th><th>Status</th></tr></thead>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td class="product-cell">
                            <div class="product-cell-inner">
                                <img src="{{ $product->image }}" alt="">
                                <span>{{ $product->name }}</span>
                            </div>
                        </td>
                        <td>{{ $product->category }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ \App\Support\Money::inr($product->price) }}</td>
                        <td><span class="status">{{ $product->badge }}</span></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection
