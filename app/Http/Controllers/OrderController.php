<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

class OrderController extends Controller
{
    private const STATUSES = ['placed', 'packed', 'shipped', 'transit', 'delivered', 'cancelled'];

    public function checkout(Request $request): View
    {
        $cart = app(CartController::class)->cartViewData($request);
        abort_if($cart['items']->isEmpty(), 403, 'Your bag is empty.');

        return view('store.checkout', $cart + [
            'savedAddresses' => collect(Auth::user()->saved_addresses ?? [])->take(5)->values(),
            'razorpayKey' => config('services.razorpay.key'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'phone' => ['required', 'regex:/^[6-9][0-9]{9}$/'],
            'address' => ['required', 'string', 'max:240'],
            'city' => ['required', 'string', 'max:120'],
            'postal_code' => ['required', 'digits:6'],
            'payment_method' => ['required', 'string', 'in:cod,razorpay'],
            'payment_reference' => ['nullable', 'string', 'max:120'],
            'razorpay_order_id' => ['nullable', 'string', 'max:120'],
            'razorpay_signature' => ['nullable', 'string', 'max:255'],
        ], [
            'phone.regex' => 'Phone number must be exactly 10 digits and start with 6, 7, 8, or 9.',
            'postal_code.digits' => 'Pincode must be exactly 6 digits.',
        ]);

        if ($data['payment_method'] === 'razorpay' && blank($data['payment_reference'])) {
            return back()->withErrors(['payment_method' => 'Complete Razorpay payment before placing an online order.'])->withInput();
        }

        if ($data['payment_method'] === 'razorpay' && ! $this->validRazorpaySignature($data)) {
            return back()->withErrors(['payment_method' => 'Razorpay payment verification failed. Please try again.'])->withInput();
        }

        $cart = $request->session()->get('cart', []);
        $productIds = collect(array_keys($cart))->map(fn ($key) => explode('|', $key, 2)[0])->unique()->values()->all();
        $products = Product::whereIn('_id', $productIds)->get();
        abort_if($products->isEmpty(), 403, 'Your bag is empty.');

        $items = $products->map(function (Product $product) use ($cart) {
            return collect($cart)
                ->filter(fn ($quantity, $key) => explode('|', $key, 2)[0] === $product->getKey())
                ->map(function ($quantity, $key) use ($product) {
                    $quantity = min((int) $quantity, (int) $product->stock);
                    $color = explode('|', $key, 2)[1] ?? 'Standard';

                    return [
                        'product_id' => $product->getKey(),
                        'name' => $product->name,
                        'slug' => $product->slug,
                        'image' => $product->image,
                        'room' => $product->category,
                        'type' => $product->sub_category,
                        'material' => $product->material,
                        'color' => $color,
                        'price' => $product->price,
                        'quantity' => $quantity,
                        'line_total' => $quantity * $product->price,
                    ];
                });
        })->flatten(1)->values();

        $order = Order::create([
            'user_id' => Auth::id(),
            'customer' => [
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'phone' => $data['phone'],
            ],
            'items' => $items->all(),
            'subtotal' => $items->sum('line_total'),
            'status' => 'placed',
            'payment' => [
                'method' => ($data['payment_method'] ?? 'cod') === 'razorpay' ? 'Razorpay' : 'Cash on Delivery',
                'status' => ($data['payment_method'] ?? 'cod') === 'razorpay' ? 'paid' : 'pending',
                'reference' => $data['payment_reference'] ?? null,
                'razorpay_order_id' => $data['razorpay_order_id'] ?? null,
                'razorpay_signature' => $data['razorpay_signature'] ?? null,
                'paid_at' => ($data['payment_method'] ?? 'cod') === 'razorpay' ? now()->toDateTimeString() : null,
            ],
            'shipping_address' => [
                'address' => $data['address'],
                'city' => $data['city'],
                'postal_code' => $data['postal_code'],
            ],
        ]);

        foreach ($items as $item) {
            $product = Product::find($item['product_id']);

            if ($product) {
                $product->stock = max(0, (int) $product->stock - (int) $item['quantity']);
                $product->save();
            }
        }

        $this->rememberAddress($data);
        $request->session()->forget('cart');

        return redirect()->route('orders.show', $order)->with('status', 'Order placed successfully.');
    }

    private function rememberAddress(array $data): void
    {
        $user = Auth::user();
        $address = [
            'phone' => $data['phone'],
            'address' => $data['address'],
            'city' => $data['city'],
            'postal_code' => $data['postal_code'],
        ];
        $saved = collect($user->saved_addresses ?? [])
            ->reject(fn (array $item) => ($item['address'] ?? '') === $address['address'] && ($item['postal_code'] ?? '') === $address['postal_code'])
            ->prepend($address)
            ->take(5)
            ->values()
            ->all();

        $user->saved_addresses = $saved;
        $user->save();
    }

    public function createRazorpayOrder(Request $request)
    {
        $cart = app(CartController::class)->cartViewData($request);
        abort_if($cart['items']->isEmpty(), 403, 'Your bag is empty.');

        $key = config('services.razorpay.key');
        $secret = config('services.razorpay.secret');

        abort_if(blank($key) || blank($secret), 422, 'Add RAZORPAY_KEY_ID and RAZORPAY_KEY_SECRET in .env.');

        $response = Http::withBasicAuth($key, $secret)
            ->asJson()
            ->post('https://api.razorpay.com/v1/orders', [
                'amount' => (int) round($cart['subtotal'] * 100),
                'currency' => 'INR',
                'receipt' => 'si_'.now()->format('ymdHis').'_'.Str::random(6),
                'payment_capture' => 1,
                'notes' => [
                    'customer_email' => Auth::user()->email,
                    'source' => 'satya_interiors_checkout',
                ],
            ]);

        abort_if($response->failed(), 422, $response->json('error.description') ?? 'Unable to create Razorpay order.');

        return response()->json([
            'id' => $response->json('id'),
            'amount' => $response->json('amount'),
            'currency' => $response->json('currency', 'INR'),
        ]);
    }

    private function validRazorpaySignature(array $data): bool
    {
        $secret = config('services.razorpay.secret');

        if (blank($secret) || blank($data['razorpay_order_id'] ?? null) || blank($data['razorpay_signature'] ?? null)) {
            return false;
        }

        $payload = ($data['razorpay_order_id'] ?? '').'|'.($data['payment_reference'] ?? '');
        $expected = hash_hmac('sha256', $payload, $secret);

        return hash_equals($expected, $data['razorpay_signature']);
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        abort_unless(Auth::user()?->is_admin, 403);

        $data = $request->validate([
            'status' => ['required', 'string', 'in:'.implode(',', self::STATUSES)],
        ]);

        $previousStatus = $order->status;
        $updates = ['status' => $data['status']];

        if ($data['status'] === 'cancelled') {
            $updates['payment'] = array_merge($order->payment ?? [], [
                'status' => ($order->payment['status'] ?? null) === 'paid' ? 'refund pending' : 'cancelled',
            ]);
        }

        $order->update($updates);
        $order->refresh();

        if ($previousStatus !== $order->status) {
            $this->sendOrderStatusMail($order);

            if ($order->status === 'delivered') {
                $this->sendInvoiceMail($order);
            }
        }

        return redirect()->route('orders.show', $order)->with('status', 'Order status updated.');
    }

    public function cancel(Order $order): RedirectResponse
    {
        abort_unless($order->user_id === Auth::id(), 403);
        abort_if(in_array($order->status, ['shipped', 'transit', 'delivered', 'cancelled'], true), 403, 'This order can no longer be cancelled.');

        $order->update([
            'status' => 'cancelled',
            'payment' => array_merge($order->payment ?? [], [
                'status' => ($order->payment['status'] ?? null) === 'paid' ? 'refund pending' : 'cancelled',
            ]),
        ]);

        return redirect()->route('orders.show', $order)->with('status', 'Order cancelled successfully.');
    }

    public function index(Request $request): View
    {
        $orders = Order::where('user_id', Auth::id())->latest()->get();
        $orders = $this->filterOrders($orders, $request);

        return view('store.orders', [
            'orders' => $orders,
            'statuses' => collect(self::STATUSES),
            'filters' => $request->only(['q', 'status', 'min_price', 'max_price', 'date_from', 'date_to']),
        ]);
    }

    public function show(Order $order): View
    {
        abort_unless($order->user_id === Auth::id() || Auth::user()?->is_admin, 403);

        return view('store.order-show', [
            'order' => $order,
            'statuses' => self::STATUSES,
        ]);
    }

    private function filterOrders($orders, Request $request)
    {
        return $orders
            ->when($request->filled('q'), function ($orders) use ($request) {
                $term = Str::lower($request->string('q')->toString());

                return $orders->filter(function (Order $order) use ($term) {
                    $customer = implode(' ', $order->customer ?? []);
                    $address = implode(' ', $order->shipping_address ?? []);
                    $products = collect($order->items ?? [])->pluck('name')->implode(' ');
                    $haystack = Str::lower($customer.' '.$address.' '.$products);

                    return str_contains($haystack, $term);
                });
            })
            ->when($request->filled('status'), fn ($orders) => $orders->where('status', $request->status))
            ->when($request->filled('min_price'), fn ($orders) => $orders->filter(fn (Order $order) => $order->subtotal >= (float) $request->min_price))
            ->when($request->filled('max_price'), fn ($orders) => $orders->filter(fn (Order $order) => $order->subtotal <= (float) $request->max_price))
            ->when($request->filled('date_from'), fn ($orders) => $orders->filter(fn (Order $order) => $order->created_at?->gte(Carbon::parse($request->date_from)->startOfDay())))
            ->when($request->filled('date_to'), fn ($orders) => $orders->filter(fn (Order $order) => $order->created_at?->lte(Carbon::parse($request->date_to)->endOfDay())))
            ->values();
    }

    private function sendOrderStatusMail(Order $order): void
    {
        $email = $order->customer['email'] ?? null;

        if (! $email) {
            return;
        }

        $status = ucfirst($order->status);
        $orderId = $order->getKey();

        Mail::raw(
            "Hello {$order->customer['name']},\n\nYour Satya Interiors order {$orderId} is now {$status}.\n\nThank you for shopping with us.",
            function ($message) use ($email, $status, $orderId) {
                $message->to($email)->subject("Order {$orderId} status: {$status}");
            }
        );
    }

    private function sendInvoiceMail(Order $order): void
    {
        $email = $order->customer['email'] ?? null;

        if (! $email) {
            return;
        }

        Mail::send('emails.invoice', ['order' => $order], function ($message) use ($email, $order) {
            $message->to($email)->subject('Invoice for order '.$order->getKey());
        });
    }
}
