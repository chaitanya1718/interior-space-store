<article class="product-card">
    <a class="product-image" href="{{ route('products.show', $product->slug) }}">
        <img src="{{ $product->image }}" alt="{{ $product->name }}">
        <span>{{ $product->badge }}</span>
    </a>
    <div class="product-meta">
        <p>{{ $product->category }}</p>
        <h3><a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a></h3>
        <div>
            <span>{{ $product->sub_category ?? $product->material }}</span>
            <strong>{{ \App\Support\Money::inr($product->price) }}</strong>
        </div>
    </div>
</article>
