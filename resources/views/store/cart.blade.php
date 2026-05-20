@extends('layouts.store')

@section('title', 'Shopping Bag | Satya Interiors')

@section('content')
<main class="page">
    <section class="shop-heading">
        <p class="eyebrow">Shopping bag</p>
        <h1>Your selected pieces</h1>
    </section>

    @if(session('status'))<p class="notice">{{ session('status') }}</p>@endif

    @if($items->isEmpty())
        <section class="form-panel"><p>Your bag is empty.</p><a class="button" href="{{ route('shop') }}">Shop collection</a></section>
    @else
        <form method="POST" action="{{ route('cart.update') }}" class="cart-layout">
            @csrf
            @method('PATCH')
            <div class="cart-items">
                @foreach($items as $item)
                    <article class="cart-row">
                        <img src="{{ $item['product']->image }}" alt="{{ $item['product']->name }}">
                        <div>
                            <h3>{{ $item['product']->name }}</h3>
                            <p>{{ $item['product']->material }} · {{ $item['color'] }}</p>
                            <button class="delete-cart-item" type="submit" name="remove_item" value="{{ $item['key'] }}">
                                <i data-lucide="trash-2"></i>
                                Delete item
                            </button>
                        </div>
                        <input name="items[{{ $item['key'] }}]" type="number" min="0" max="{{ $item['product']->stock }}" value="{{ $item['quantity'] }}">
                        <strong>{{ \App\Support\Money::inr($item['line_total']) }}</strong>
                    </article>
                @endforeach
            </div>
            <aside class="summary-panel">
                <h2>Summary</h2>
                <div><span>Subtotal</span><strong>{{ \App\Support\Money::inr($subtotal) }}</strong></div>
                <button class="button ghost" type="submit">Update bag</button>
                <a class="button" href="{{ route('checkout') }}">Checkout</a>
            </aside>
        </form>
    @endif
</main>
@endsection
