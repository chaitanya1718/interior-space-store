<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function show(Request $request): View
    {
        return view('store.cart', $this->cartViewData($request));
    }

    public function add(Request $request, Product $product): RedirectResponse
    {
        abort_unless($product->is_active, 404);

        $quantity = max(1, min((int) $request->input('quantity', 1), $product->stock));
        $color = (string) $request->input('color', data_get($product->color_options, '0.name', 'Standard'));
        $key = $product->getKey().'|'.$color;
        $cart = $request->session()->get('cart', []);
        $cart[$key] = min(($cart[$key] ?? 0) + $quantity, $product->stock);
        $request->session()->put('cart', $cart);

        return redirect()->route('cart.show')->with('status', 'Added to bag.');
    }

    public function update(Request $request): RedirectResponse
    {
        if ($request->filled('remove_item')) {
            $cart = $request->session()->get('cart', []);
            unset($cart[$request->string('remove_item')->toString()]);
            $request->session()->put('cart', $cart);

            return redirect()->route('cart.show')->with('status', 'Item removed from bag.');
        }

        $data = $request->validate([
            'items' => ['array'],
            'items.*' => ['integer', 'min:0'],
        ]);

        $cart = [];
        foreach (($data['items'] ?? []) as $id => $quantity) {
            if ($quantity > 0) {
                $cart[$id] = $quantity;
            }
        }

        $request->session()->put('cart', $cart);

        return redirect()->route('cart.show')->with('status', 'Bag updated.');
    }

    public function cartViewData(Request $request): array
    {
        $cart = $request->session()->get('cart', []);
        $productIds = collect(array_keys($cart))->map(fn ($key) => explode('|', $key, 2)[0])->unique()->values()->all();
        $products = Product::whereIn('_id', $productIds)->get();
        $items = $products->map(function (Product $product) use ($cart) {
            return collect($cart)
                ->filter(fn ($quantity, $key) => explode('|', $key, 2)[0] === $product->getKey())
                ->map(function ($quantity, $key) use ($product) {
                    $quantity = min((int) $quantity, $product->stock);
                    $color = explode('|', $key, 2)[1] ?? 'Standard';

                    return [
                        'key' => $key,
                        'product' => $product,
                        'color' => $color,
                        'quantity' => $quantity,
                        'line_total' => $quantity * $product->price,
                    ];
                });
        })->flatten(1);

        return [
            'items' => $items,
            'subtotal' => $items->sum('line_total'),
        ];
    }
}
