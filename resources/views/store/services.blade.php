@extends('layouts.store')

@section('title', 'Interior Services | Satya Interiors')

@section('content')
<main class="page services-page">
    <section class="shop-heading">
        <p class="eyebrow">Interior services</p>
        <h1>Offers and planning for complete rooms.</h1>
        <p>Start with current product offers, then use the planner to find the room combinations that fit your project.</p>
    </section>

    <section class="compact-section">
        <div class="offer-grid">
            <a class="offer-banner large" href="{{ route('shop', ['sub_category' => 'Furniture']) }}">
                <img src="https://images.unsplash.com/photo-1616046229478-9901c5536a45?auto=format&fit=crop&w=1400&q=80" alt="Modern furniture setting">
                <span>Furniture edit</span>
                <strong>Complete room pieces from ₹34,000</strong>
            </a>
            <a class="offer-banner" href="{{ route('shop', ['sub_category' => 'Lighting']) }}">
                <img src="https://images.unsplash.com/photo-1524484485831-a92ffc0de03f?auto=format&fit=crop&w=1000&q=80" alt="Warm pendant lighting">
                <span>Lighting offers</span>
                <strong>Layer your home with warm light</strong>
            </a>
            <a class="offer-banner" href="{{ route('shop', ['sub_category' => 'Storage']) }}">
                <img src="https://images.unsplash.com/photo-1618220179428-22790b461013?auto=format&fit=crop&w=1000&q=80" alt="Styled interior storage">
                <span>Storage picks</span>
                <strong>Smarter storage for daily living</strong>
            </a>
        </div>
    </section>

    <section class="compact-section" id="planner">
        <div class="planner-panel services-planner">
            <div>
                <p class="eyebrow">Interior planner</p>
                <h3>Build a combination from your needs</h3>
                <p>Select the room and must-have items to see matching products instantly.</p>
            </div>
            <form class="planner-form" method="GET" action="{{ route('shop') }}">
                <label>Room
                    <select name="category">
                        <option>Living Room</option>
                        <option>Dining</option>
                        <option>Bedroom</option>
                        <option>Office</option>
                        <option>Kids Play</option>
                        <option>Toilet / Restroom</option>
                    </select>
                </label>
                <label>Need
                    <select name="sub_category">
                        <option value="">Complete room setup</option>
                        <option value="Furniture">Furniture</option>
                        <option value="Lighting">Lighting</option>
                        <option value="Decor">Decor</option>
                        <option value="Textiles">Textiles</option>
                        <option value="Storage">Storage</option>
                    </select>
                </label>
                <button class="button" type="submit">Explore matches</button>
            </form>
        </div>
    </section>
</main>
@endsection
