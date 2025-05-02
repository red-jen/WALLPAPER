<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with(['user', 'orderItems.wallpaper'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.wallpaper']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update the order status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order->update([
            'status' => $request->status,
        ]);

        // Log this activity
        if (class_exists(\App\Models\Activity::class)) {
            \App\Models\Activity::log(
                'order_updated',
                "Order #{$order->order_number} status updated to {$request->status}",
                auth()->user(),
                $order
            );
        }

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Order status has been updated successfully.');
    }
}
