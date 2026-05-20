@extends('layouts.store')

@section('title', 'Order Details | Satya Interiors')

@section('content')
<main class="page">
    <section class="shop-heading">
        <p class="eyebrow">Order {{ $order->getKey() }}</p>
        <h1>Order details</h1>
        <p>
            Status: {{ ucfirst($order->status) }}
            @if(($order->payment['status'] ?? null) === 'paid')
                · Total paid: {{ \App\Support\Money::inr($order->subtotal) }}
            @else
                · Amount: {{ \App\Support\Money::inr($order->subtotal) }}
            @endif
        </p>
    </section>
    @if(session('status'))<p class="notice">{{ session('status') }}</p>@endif

    <section class="checkout-layout">
        <div class="admin-panel order-detail-panel">
            <div class="section-head split">
                <div>
                    <p class="eyebrow">Products</p>
                    <h2>Purchased items</h2>
                </div>
                <span class="status">{{ $order->status }}</span>
            </div>
            <div class="order-item-list">
                @foreach($order->items as $item)
                    @php($product = \App\Models\Product::find($item['product_id'] ?? null))
                    <article class="order-item-card">
                        <img src="{{ $item['image'] ?? $product?->image }}" alt="{{ $item['name'] }}">
                        <div>
                            <p class="eyebrow">{{ $item['type'] ?? $product?->sub_category ?? 'Product' }}</p>
                            <h3>{{ $item['name'] }}</h3>
                            <p>Product ID: {{ $item['product_id'] ?? 'N/A' }}</p>
                            <p>Color: {{ $item['color'] ?? 'Standard' }} · Qty: {{ $item['quantity'] }}</p>
                            <p>Room: {{ $item['room'] ?? $product?->category ?? 'N/A' }}</p>
                            <p>Material: {{ $item['material'] ?? $product?->material ?? 'N/A' }}</p>
                            @if($product)
                                <a class="text-link" href="{{ route('products.show', $product->slug) }}">View product page</a>
                            @endif
                        </div>
                        <strong>{{ \App\Support\Money::inr($item['line_total']) }}</strong>
                    </article>
                @endforeach
            </div>
            <div class="summary-line summary-total">
                <span>{{ ($order->payment['status'] ?? null) === 'paid' ? 'Total paid' : 'Order total' }}</span>
                <strong>{{ \App\Support\Money::inr($order->subtotal) }}</strong>
            </div>
        </div>

        <aside class="summary-panel">
            <h2>Delivery</h2>
            <p>{{ $order->customer['name'] ?? '' }}<br>{{ $order->customer['email'] ?? '' }}<br>{{ $order->customer['phone'] ?? '' }}</p>
            <p>{{ $order->shipping_address['address'] ?? '' }}<br>{{ $order->shipping_address['city'] ?? '' }} {{ $order->shipping_address['postal_code'] ?? '' }}</p>

            <h2>Payment</h2>
            <p>{{ $order->payment['method'] ?? 'Cash on Delivery' }}<br>Status: {{ $order->payment['status'] ?? 'pending' }}</p>
            @if($order->payment['reference'] ?? null)
                <p>Reference: {{ $order->payment['reference'] }}</p>
            @endif

            @if(! auth()->user()?->is_admin && ! in_array($order->status, ['shipped', 'transit', 'delivered', 'cancelled'], true))
                <form method="POST" action="{{ route('orders.cancel', $order) }}" class="stack-form status-update-form">
                    @csrf
                    @method('PATCH')
                    <button class="button ghost" type="submit">Cancel order</button>
                </form>
            @endif

            @if(auth()->user()?->is_admin)
                <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="stack-form status-update-form">
                    @csrf
                    @method('PATCH')
                    <label>Update status
                        <select name="status">
                            @foreach($statuses as $status)
                                <option value="{{ $status }}" @selected($order->status === $status)>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </label>
                    <button class="button" type="submit">Update status</button>
                </form>
            @endif
        </aside>
    </section>
</main>
@endsection
