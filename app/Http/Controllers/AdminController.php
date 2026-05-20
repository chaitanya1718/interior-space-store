<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        abort_unless(auth()->user()?->is_admin, 403);

        $products = Product::latest()->take(6)->get();
        $orders = Order::latest()->take(5)->get();
        $allOrders = Order::all();
        $deliveredOrders = $allOrders->where('status', 'delivered');
        $revenueChart = collect(range(6, 0))->map(function (int $daysAgo) use ($allOrders) {
            $date = now()->subDays($daysAgo);
            $total = $allOrders
                ->where('status', 'delivered')
                ->filter(fn (Order $order) => $order->created_at?->isSameDay($date))
                ->sum('subtotal');

            return [
                'label' => $date->format('d M'),
                'total' => $total,
            ];
        });
        $maxRevenue = max(1, $revenueChart->max('total') ?? 1);

        return view('admin.dashboard', [
            'products' => $products,
            'orders' => $orders,
            'revenueChart' => $revenueChart,
            'maxRevenue' => $maxRevenue,
            'stats' => [
                'products' => Product::count(),
                'stock' => Product::sum('stock'),
                'orders' => Order::count(),
                'revenue' => $deliveredOrders->sum('subtotal'),
            ],
        ]);
    }
}
