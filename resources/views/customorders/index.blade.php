@extends(auth()->user()?->is_admin ? 'layouts.admin' : 'layouts.store')

@section('title', 'Custom Orders | Satya Interiors')

@section('content')
<main class="{{ auth()->user()?->is_admin ? '' : 'page' }}">
    <section class="shop-heading">
        <p class="eyebrow">Custom interiors</p>
        <h1>{{ auth()->user()?->is_admin ? 'Custom order appointments' : 'Book a custom order' }}</h1>
    </section>

    @if(session('status'))<p class="notice">{{ session('status') }}</p>@endif

    @unless(auth()->user()?->is_admin)
        <section class="checkout-layout custom-order-layout">
            <form method="POST" action="{{ route('customorders.store') }}" class="form-panel stack-form" data-disable-on-submit>
                @csrf
                <label>Phone <input name="phone" inputmode="numeric" pattern="[6-9][0-9]{9}" maxlength="10" value="{{ old('phone') }}" required></label>
                <label>Room
                    <select name="room" required>
                        <option value="">Select room</option>
                        @foreach(['Living Room', 'Bedroom', 'Dining', 'Office', 'Kitchen', 'Balcony', 'Kids Play', 'Toilet / Restroom'] as $room)
                            <option value="{{ $room }}" @selected(old('room') === $room)>{{ $room }}</option>
                        @endforeach
                    </select>
                </label>
                <label>Preferred appointment date <input name="preferred_date" type="date" min="{{ now()->toDateString() }}" value="{{ old('preferred_date') }}" required></label>
                <label>Approx budget <input name="budget" type="number" min="0" step="1000" value="{{ old('budget') }}"></label>
                <label>Needs <textarea name="needs" required placeholder="Tell us what furniture, layout, material, color, or storage help you need.">{{ old('needs') }}</textarea></label>
                @if($errors->any())<p class="form-error">{{ $errors->first() }}</p>@endif
                <button class="button" type="submit" data-loading-text="Booking...">Book appointment</button>
            </form>

            <aside class="summary-panel">
                <h2>What happens next</h2>
                <p>Our team will review your needs and contact you for the selected appointment date.</p>
            </aside>
        </section>
    @endunless

    <section class="admin-panel">
        <div class="section-head split">
            <div>
                <p class="eyebrow">{{ auth()->user()?->is_admin ? 'Requests' : 'Your requests' }}</p>
                <h2>Appointments</h2>
            </div>
        </div>
        <div class="table-wrap">
            <table class="admin-table custom-orders-table">
                <thead><tr><th>Customer</th><th>Room</th><th>Needs</th><th>Budget</th><th>Date</th><th>Status</th>@if(auth()->user()?->is_admin)<th>Update</th>@endif</tr></thead>
                <tbody>
                    @forelse($customOrders as $customOrder)
                        <tr>
                            <td class="order-customer">
                                <strong>{{ $customOrder->customer['name'] ?? 'Customer' }}</strong>
                                <span>{{ $customOrder->customer['email'] ?? '' }}</span>
                                <span>{{ $customOrder->customer['phone'] ?? '' }}</span>
                            </td>
                            <td>{{ $customOrder->room }}</td>
                            <td class="order-products">{{ $customOrder->needs }}</td>
                            <td>{{ $customOrder->budget ? \App\Support\Money::inr($customOrder->budget) : 'Not set' }}</td>
                            <td>{{ $customOrder->preferred_date?->format('d M Y') }}</td>
                            <td><span class="status">{{ $customOrder->status }}</span></td>
                            @if(auth()->user()?->is_admin)
                                <td>
                                    <form method="POST" action="{{ route('customorders.status', $customOrder) }}" class="table-status-form">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status">
                                            @foreach(['approved', 'completed', 'rejected'] as $status)
                                                <option value="{{ $status }}" @selected($customOrder->status === $status)>{{ ucfirst($status) }}</option>
                                            @endforeach
                                        </select>
                                        <button class="button" type="submit">Save</button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr><td colspan="{{ auth()->user()?->is_admin ? 7 : 6 }}" class="empty-cell">No custom order appointments yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</main>
@endsection
