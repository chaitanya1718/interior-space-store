@extends('layouts.admin')

@section('title', 'Admin Orders | Satya Interiors')

@section('content')
    <section class="shop-heading">
        <p class="eyebrow">Admin</p>
        <h1>Orders</h1>
    </section>

    <form method="GET" action="{{ route('admin.orders') }}" class="filter-bar order-filter">
        <label>Customer, product, address <input name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Search orders"></label>
        <label>Status
            <select name="status">
                <option value="">All status</option>
                @foreach($statuses as $status)
                    <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </label>
        <label>Min price <input name="min_price" type="number" min="0" step="0.01" value="{{ $filters['min_price'] ?? '' }}"></label>
        <label>Max price <input name="max_price" type="number" min="0" step="0.01" value="{{ $filters['max_price'] ?? '' }}"></label>
        <label>From <input name="date_from" type="date" value="{{ $filters['date_from'] ?? '' }}"></label>
        <label>To <input name="date_to" type="date" value="{{ $filters['date_to'] ?? '' }}"></label>
        <div class="filter-actions">
            <button class="button" type="submit">Filter</button>
            <a class="button ghost" href="{{ route('admin.orders') }}">Clear</a>
        </div>
    </form>

    <section class="admin-panel">
        <div class="table-wrap">
            <table class="admin-table orders-table">
                <thead><tr><th>Order</th><th>Customer</th><th>Products</th><th>Address</th><th>Status</th><th>Total</th><th>Date</th><th class="actions-head">Actions</th></tr></thead>
                <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td class="order-id">{{ $order->getKey() }}</td>
                        <td class="order-customer"><strong>{{ $order->customer['name'] ?? 'Customer' }}</strong><span>{{ $order->customer['email'] ?? '' }}</span></td>
                        <td class="order-products">{{ collect($order->items ?? [])->pluck('name')->implode(', ') }}</td>
                        <td class="order-address">{{ $order->shipping_address['address'] ?? '' }}<br>{{ $order->shipping_address['city'] ?? '' }} {{ $order->shipping_address['postal_code'] ?? '' }}</td>
                        <td><span class="status">{{ $order->status }}</span></td>
                        <td>{{ \App\Support\Money::inr($order->subtotal) }}</td>
                        <td>{{ $order->created_at?->format('d M Y') }}</td>
                        <td class="table-actions single-action"><a class="text-link" href="{{ route('orders.show', $order) }}">View</a></td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="empty-cell">No orders match your filters.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
