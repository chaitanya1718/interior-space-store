@extends('layouts.admin')

@section('title', ($product->exists ? 'Edit' : 'Add').' Product | Satya Interiors')

@section('content')
    <section class="shop-heading">
        <p class="eyebrow">Admin</p>
        <h1>{{ $product->exists ? 'Edit product' : 'Add product' }}</h1>
        <p>Update storefront price, quantity, description, material, room, details, image, colors, and visibility.</p>
    </section>
    <form method="POST" action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}" class="form-panel stack-form product-form">
        @csrf
        @if($product->exists) @method('PUT') @endif
        <label>Name <input name="name" value="{{ old('name', $product->name) }}" required></label>
        <div class="form-grid">
            <label>Room category
                <select name="category">
                    <option value="">Select room</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" @selected(old('category', $product->category) === $category)>{{ $category }}</option>
                    @endforeach
                </select>
            </label>
            <label>Add new room category <input name="new_category" value="{{ old('new_category') }}" placeholder="Example: Puja Room"></label>
        </div>
        <div class="form-grid">
            <label>Product sub-category
                <select name="sub_category">
                    <option value="">Select type</option>
                    @foreach($subCategories as $subCategory)
                        <option value="{{ $subCategory }}" @selected(old('sub_category', $product->sub_category) === $subCategory)>{{ $subCategory }}</option>
                    @endforeach
                </select>
            </label>
            <label>Add new sub-category <input name="new_sub_category" value="{{ old('new_sub_category') }}" placeholder="Example: False Ceiling"></label>
        </div>
        <div class="form-grid">
            <label>Price in INR <input name="price" type="number" step="1" min="0" value="{{ old('price', $product->price) }}" required></label>
            <label>Stock <input name="stock" type="number" min="0" value="{{ old('stock', $product->stock ?? 0) }}" required></label>
        </div>
        <label>Badge <input name="badge" value="{{ old('badge', $product->badge) }}"></label>
        <label>Material / finish detail <input name="material" value="{{ old('material', $product->material) }}" placeholder="Example: Teak wood, linen upholstery" required></label>
        <label>Image URL <input name="image" type="url" value="{{ old('image', $product->image) }}" required></label>
        <label>Description <textarea name="description" required>{{ old('description', $product->description) }}</textarea></label>
        <label>Details, one per line <textarea name="details">{{ old('details', implode(PHP_EOL, $product->details ?? [])) }}</textarea></label>
        <label>Color options, one per line as Name | #hex | optional image URL <textarea name="color_options" placeholder="Warm Oak | #8d6e63 | https://example.com/oak-chair.jpg">{{ old('color_options', collect($product->color_options ?? [])->map(fn ($color) => ($color['name'] ?? '').' | '.($color['hex'] ?? '').(($color['image'] ?? null) ? ' | '.$color['image'] : ''))->implode(PHP_EOL)) }}</textarea></label>
        <label class="check"><input name="is_active" type="checkbox" value="1" @checked(old('is_active', $product->is_active ?? true))> Active on storefront</label>
        @if($errors->any())<p class="form-error">{{ $errors->first() }}</p>@endif
        <button class="button" type="submit">{{ $product->exists ? 'Save product' : 'Create product' }}</button>
    </form>
@endsection
