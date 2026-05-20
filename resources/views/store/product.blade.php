@extends('layouts.store')

@section('title', $product->name.' | Satya Interiors')

@section('content')
<main class="page product-page">
    <section class="product-detail">
        <div class="gallery">
            @php($initialColor = data_get($product->color_options, '0.hex', '#e4e4cc'))
            @php($initialImage = data_get($product->color_options, '0.image', $product->image))
            <div class="model-preview @if($initialImage !== $product->image) has-variant-image @endif" data-color-preview data-original-image="{{ $product->image }}" style="--preview-color: {{ $initialColor }}">
                <img class="main-photo" src="{{ $initialImage }}" alt="{{ $product->name }}">
            </div>
        </div>
        <div class="product-buy">
            <p class="eyebrow">{{ $product->sub_category ?? $product->category }}</p>
            <h1>{{ $product->name }}</h1>
            <p class="price">{{ \App\Support\Money::inr($product->price) }}</p>
            <p>{{ $product->description }}</p>
            <form method="POST" action="{{ route('cart.add', $product) }}">
                @csrf
                <fieldset class="color-options">
                    <legend>Color / finish</legend>
                    @forelse($product->color_options ?? [] as $index => $color)
                        <label>
                            <input type="radio" name="color" value="{{ $color['name'] }}" data-preview-color="{{ $color['hex'] }}" data-preview-image="{{ $color['image'] ?? '' }}" @checked($index === 0)>
                            <span style="--swatch:{{ $color['hex'] }}" title="{{ $color['name'] }}"></span>
                            <em>{{ $color['name'] }}</em>
                        </label>
                    @empty
                        <label>
                            <input type="radio" name="color" value="Standard" checked>
                            <span style="--swatch:#e4e4cc" title="Standard"></span>
                            <em>Standard</em>
                        </label>
                    @endforelse
                </fieldset>
                <label class="quantity-field">Quantity <input name="quantity" type="number" min="1" max="{{ $product->stock }}" value="1"></label>
                <button class="button wide" type="submit">Add to bag</button>
            </form>
            <dl>
                <div><dt>Room</dt><dd>{{ $product->category }}</dd></div>
                <div><dt>Type</dt><dd>{{ $product->sub_category ?? 'Furniture' }}</dd></div>
                <div><dt>Material</dt><dd>{{ $product->material }}</dd></div>
                <div><dt>Stock</dt><dd>{{ $product->stock }} available</dd></div>
                @foreach($product->details ?? [] as $detail)
                    <div><dt>Detail</dt><dd>{{ $detail }}</dd></div>
                @endforeach
            </dl>
        </div>
    </section>

    <section class="section">
        <div class="section-head"><p class="eyebrow">Pair with</p><h2>Related pieces</h2></div>
        <div class="product-grid three">
            @foreach($related as $item)
                @include('store.partials.product-card', ['product' => $item])
            @endforeach
        </div>
    </section>
</main>
@endsection
