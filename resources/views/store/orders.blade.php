@extends('layouts.store')

@section('title', 'My Orders | Satya Interiors')

@section('content')
<main class="page">
    <section class="shop-heading">
        <p class="eyebrow">Account</p>
        <h1>My orders</h1>
    </section>
    @if(session('status'))<p class="notice">{{ session('status') }}</p>@endif

    <form method="GET" action="{{ route('orders.index') }}" class="filter-bar order-filter">
        <label>Customer, product, address <input name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Search your orders"></label>
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
            <a class="button ghost" href="{{ route('orders.index') }}">Clear</a>
        </div>
    </form>

    <section class="admin-panel">
        <div class="table-wrap">
            <table class="admin-table orders-table">
                <thead><tr><th>Order</th><th>Products</th><th>Address</th><th>Date</th><th>Status</th><th>Total</th><th class="actions-head">Actions</th></tr></thead>
                <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td class="order-id">{{ $order->getKey() }}</td>
                        <td class="order-products">{{ collect($order->items ?? [])->pluck('name')->implode(', ') }}</td>
                        <td class="order-address">{{ $order->shipping_address['address'] ?? '' }}<br>{{ $order->shipping_address['city'] ?? '' }} {{ $order->shipping_address['postal_code'] ?? '' }}</td>
                        <td>{{ $order->created_at?->format('d M Y') }}</td>
                        <td><span class="status">{{ $order->status }}</span></td>
                        <td>{{ \App\Support\Money::inr($order->subtotal) }}</td>
                        <td class="table-actions">
                            <a class="text-link" href="{{ route('orders.show', $order) }}">View</a>
                            @if(! in_array($order->status, ['shipped', 'transit', 'delivered', 'cancelled'], true))
                                <form method="POST" action="{{ route('orders.cancel', $order) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button class="link-button" type="submit">Cancel</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="empty-cell">No orders match your filters.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </section>
</main>
@endsection
