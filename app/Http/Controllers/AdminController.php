<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(Request $request): View
    {
        abort_unless(auth()->user()?->is_admin, 403);

        $revenuePage = max(0, (int) $request->query('revenue_page', 0));
        $revenueEndDate = now()->subDays($revenuePage * 7)->endOfDay();
        $revenueStartDate = $revenueEndDate->copy()->subDays(6)->startOfDay();

        $products = Product::latest()->take(6)->get();
        $orders = Order::latest()->take(5)->get();
        $allOrders = Order::all();
        $deliveredOrders = $allOrders->where('status', 'delivered');
        $revenueChart = collect(range(0, 6))->map(function (int $dayOffset) use ($allOrders, $revenueStartDate) {
            $date = $revenueStartDate->copy()->addDays($dayOffset);
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
        $revenueWindowTotal = $revenueChart->sum('total');

        return view('admin.dashboard', [
            'products' => $products,
            'orders' => $orders,
            'revenueChart' => $revenueChart,
            'revenueWindow' => [
                'page' => $revenuePage,
                'title' => $revenuePage === 0 ? 'Last 7 days' : $revenueStartDate->format('d M') . ' - ' . $revenueEndDate->format('d M'),
                'start' => $revenueStartDate->format('d M Y'),
                'end' => $revenueEndDate->format('d M Y'),
                'total' => $revenueWindowTotal,
                'newerUrl' => $revenuePage > 1
                    ? route('admin.dashboard', ['revenue_page' => $revenuePage - 1])
                    : route('admin.dashboard'),
                'olderUrl' => route('admin.dashboard', ['revenue_page' => $revenuePage + 1]),
            ],
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
