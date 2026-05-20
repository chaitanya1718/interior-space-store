<?php

namespace App\Http\Controllers;

use App\Models\CustomOrder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CustomOrderController extends Controller
{
    private const STATUSES = ['requested', 'approved', 'completed', 'rejected'];

    public function index(): View
    {
        $orders = Auth::user()?->is_admin
            ? CustomOrder::latest()->get()
            : CustomOrder::where('user_id', Auth::id())->latest()->get();

        return view('customorders.index', [
            'customOrders' => $orders,
            'statuses' => self::STATUSES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        abort_if(Auth::user()?->is_admin, 403);

        $data = $request->validate([
            'phone' => ['required', 'regex:/^[6-9][0-9]{9}$/'],
            'room' => ['required', 'string', 'max:120'],
            'needs' => ['required', 'string', 'max:1000'],
            'budget' => ['nullable', 'numeric', 'min:0'],
            'preferred_date' => ['required', 'date', 'after_or_equal:today'],
        ], [
            'phone.regex' => 'Phone number must be exactly 10 digits and start with 6, 7, 8, or 9.',
        ]);

        CustomOrder::create([
            'user_id' => Auth::id(),
            'customer' => [
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'phone' => $data['phone'],
            ],
            'room' => $data['room'],
            'needs' => $data['needs'],
            'budget' => $data['budget'] ?? null,
            'preferred_date' => $data['preferred_date'],
            'status' => 'requested',
        ]);

        return redirect()->route('customorders.index')->with('status', 'Custom order appointment booked.');
    }

    public function updateStatus(Request $request, CustomOrder $customOrder): RedirectResponse
    {
        abort_unless(Auth::user()?->is_admin, 403);

        $data = $request->validate([
            'status' => ['required', 'string', 'in:approved,completed,rejected'],
        ]);

        $customOrder->update(['status' => $data['status']]);

        return redirect()->route('customorders.index')->with('status', 'Appointment status updated.');
    }
}
