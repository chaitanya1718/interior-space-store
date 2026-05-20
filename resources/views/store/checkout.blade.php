@extends('layouts.store')

@section('title', 'Checkout | Satya Interiors')

@section('content')
<main class="page">
    <section class="shop-heading">
        <p class="eyebrow">Checkout</p>
        <h1>Delivery details</h1>
    </section>
    <section class="checkout-layout">
        <form method="POST" action="{{ route('orders.store') }}" class="form-panel stack-form" data-checkout-form>
            @csrf
            @if($savedAddresses->isNotEmpty())
                <label>Saved address
                    <select data-saved-address>
                        <option value="">Use a saved address</option>
                        @foreach($savedAddresses as $address)
                            <option
                                value="{{ $loop->index }}"
                                data-phone="{{ $address['phone'] ?? '' }}"
                                data-address="{{ $address['address'] ?? '' }}"
                                data-city="{{ $address['city'] ?? '' }}"
                                data-postal-code="{{ $address['postal_code'] ?? '' }}"
                            >
                                {{ $address['address'] ?? '' }}, {{ $address['city'] ?? '' }} {{ $address['postal_code'] ?? '' }}
                            </option>
                        @endforeach
                    </select>
                </label>
            @endif
            <label>Phone <input name="phone" inputmode="numeric" pattern="[6-9][0-9]{9}" maxlength="10" value="{{ old('phone', data_get($savedAddresses, '0.phone')) }}" required></label>
            <label>Address <textarea name="address" required>{{ old('address', data_get($savedAddresses, '0.address')) }}</textarea></label>
            <label>City <input name="city" value="{{ old('city', data_get($savedAddresses, '0.city')) }}" required></label>
            <label>Pincode <input name="postal_code" inputmode="numeric" pattern="[0-9]{6}" maxlength="6" value="{{ old('postal_code', data_get($savedAddresses, '0.postal_code')) }}" required></label>
            <input type="hidden" name="payment_method" value="{{ old('payment_method') }}" data-payment-method>
            <input type="hidden" name="payment_reference" value="{{ old('payment_reference') }}" data-payment-reference>
            <input type="hidden" name="razorpay_order_id" value="{{ old('razorpay_order_id') }}" data-razorpay-order>
            <input type="hidden" name="razorpay_signature" value="{{ old('razorpay_signature') }}" data-razorpay-signature>
            <section class="payment-panel" aria-label="Payment method">
                <p class="eyebrow">Payment</p>
                <h3>Choose payment option</h3>
                <div class="payment-options">
                    <label class="payment-option">
                        <input type="radio" name="payment_choice" value="razorpay" @checked(old('payment_method') === 'razorpay') data-payment-choice>
                        <span>
                            <strong>Pay now online</strong>
                            <small>Razorpay opens automatically. Use any enabled Razorpay test method for demo payment.</small>
                        </span>
                    </label>
                    <label class="payment-option">
                        <input type="radio" name="payment_choice" value="cod" @checked(old('payment_method') === 'cod') data-payment-choice>
                        <span>
                            <strong>Cash on delivery</strong>
                            <small>Place the order now and pay when it is delivered.</small>
                        </span>
                    </label>
                </div>
                <button
                    class="button ghost"
                    type="button"
                    data-razorpay-payment
                    data-key="{{ $razorpayKey }}"
                    data-amount="{{ (int) round($subtotal * 100) }}"
                    data-currency="INR"
                    data-name="Satya Interiors"
                    data-description="Order payment"
                    data-order-url="{{ route('checkout.razorpay-order') }}"
                    hidden
                >Open Razorpay</button>
                <p class="payment-note" data-payment-note>Select address details and a payment option to continue.</p>
            </section>
            @if($errors->any())<p class="form-error">{{ $errors->first() }}</p>@endif
            <button class="button" type="submit" data-place-order disabled>Place order</button>
        </form>
        <aside class="summary-panel">
            <h2>Order</h2>
            @foreach($items as $item)
                <div><span>{{ $item['product']->name }} · {{ $item['color'] }} x {{ $item['quantity'] }}</span><strong>{{ \App\Support\Money::inr($item['line_total']) }}</strong></div>
            @endforeach
            <div class="summary-total"><span>Total</span><strong>{{ \App\Support\Money::inr($subtotal) }}</strong></div>
        </aside>
    </section>
</main>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
@endsection
