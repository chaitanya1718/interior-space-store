@extends('layouts.store')

@section('title', 'Satya Interiors | Furniture and Interior Products')

@section('content')
<main>
    <section class="home-hero">
        <img src="https://images.unsplash.com/photo-1600210491892-03d54c0aaf87?auto=format&fit=crop&w=1800&q=80" alt="Warm modern living and dining interior">
        <div class="home-hero-copy">
            <p class="eyebrow">Curated room essentials</p>
            <h1>Shop interiors by room, mood, and everyday need.</h1>
            <div class="hero-actions">
                <a class="button" href="{{ route('shop') }}">Shop all products</a>
                <a class="button ghost" href="#categories">Browse categories</a>
            </div>
        </div>
    </section>

    <section class="section compact-section" id="categories">
        <div class="section-head split">
            <div>
                <p class="eyebrow">Shop by category</p>
                <h2>Choose your room</h2>
            </div>
            <a class="text-link" href="{{ route('shop') }}">View all</a>
        </div>
        <div class="room-strip">
            @foreach($categories as $category)
                <a class="room-pill" href="{{ route('rooms.show', $category['slug']) }}">
                    <img src="{{ $category['image'] }}" alt="{{ $category['name'] }}">
                    <span>{{ $category['name'] }}</span>
                </a>
            @endforeach
        </div>

        <div class="category-card-strip" aria-label="Product categories">
            @foreach($productCategories as $category)
                <a class="category-card" href="{{ $category['url'] }}">
                    <img src="{{ $category['image'] }}" alt="{{ $category['name'] }}">
                    <span>{{ $category['name'] }}</span>
                </a>
            @endforeach
        </div>
    </section>

    <section class="section compact-section">
        <div class="section-head split">
            <div>
                <p class="eyebrow">Fresh arrivals</p>
                <h2>New arrivals</h2>
            </div>
            <a class="text-link" href="{{ route('shop') }}">Shop latest</a>
        </div>
        <div class="product-carousel" aria-label="New arrivals carousel">
            @foreach($featured as $product)
                @include('store.partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </section>

    <section class="section compact-section">
        <div class="section-head split">
            <div>
                <p class="eyebrow">Home needs</p>
                <h2>Finish a room faster</h2>
            </div>
            <a class="text-link" href="{{ route('services') }}">Interior services</a>
        </div>
        <div class="product-carousel home-needs-carousel" aria-label="Home needs carousel">
            @foreach($homeNeeds as $product)
                @include('store.partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </section>
</main>
@endsection
