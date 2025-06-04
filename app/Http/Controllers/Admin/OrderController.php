<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OrderStatusUpdated;
use App\Notifications\OrderProductionUpdate;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index(Request $request)
    {
        $query = Order::with(['user']);

        // Filter by status if specified
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Filter by date range if specified
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search by order number or customer name/email
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $orders = $query->latest()->paginate(15);

        // Get totals for different statuses for summary
        $totals = [
            'all' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'in_production' => Order::where('status', 'in_production')->count(),
            'ready_to_ship' => Order::where('status', 'ready_to_ship')->count(),
            'shipped' => Order::where('status', 'shipped')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
            'canceled' => Order::where('status', 'canceled')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'totals'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        $order->load(['user', 'items.artwork']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update the order status.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,in_production,ready_to_ship,shipped,delivered,canceled',
        ]);

        $oldStatus = $order->status;
        $order->status = $request->status;
        $order->save();

        // Notify customer about status change if significant
        if ($oldStatus != $request->status) {
            try {
                Notification::send($order->user, new OrderStatusUpdated($order));
            } catch (\Exception $e) {
                // Log error but don't interrupt the process
                \Log::error('Failed to send order status notification: ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Order status updated successfully.');
    }

    /**
     * Update shipping information.
     */
    public function updateShipping(Request $request, Order $order)
    {
        $request->validate([
            'tracking_number' => 'nullable|string|max:100',
            'carrier' => 'nullable|string|max:100',
        ]);

        $order->tracking_number = $request->tracking_number;
        $order->carrier = $request->carrier;
        $order->save();

        // Notify customer about tracking info if provided
        if ($request->tracking_number && $request->carrier) {
            try {
                Notification::send($order->user, new OrderStatusUpdated($order));
            } catch (\Exception $e) {
                \Log::error('Failed to send tracking notification: ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Shipping information updated successfully.');
    }

    /**
     * Update production notes.
     */
    public function updateNotes(Request $request, Order $order)
    {
        $request->validate([
            'production_notes' => 'nullable|string|max:1000',
        ]);

        $order->production_notes = $request->production_notes;
        $order->save();

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Production notes updated successfully.');
    }

    /**
     * Upload a production image.
     */
    public function uploadImage(Request $request, Order $order)
    {
        $request->validate([
            'production_image' => 'required|image|max:5120',
            'stage' => 'required|string|in:initial_setup,printing,quality_check,finishing,packaging,ready_to_ship',
            'note' => 'nullable|string|max:500',
            'notify_customer' => 'nullable|boolean',
        ]);

        // Store the production image
        $path = $request->file('production_image')->store('order_production', 'public');

        // Get current production images or initialize empty array
        $productionImages = $order->production_images ?? [];

        // Add new image with metadata
        $productionImages[] = [
            'path' => $path,
            'stage' => $request->stage,
            'note' => $request->note,
            'created_at' => now()->toDateTimeString(),
        ];

        $order->production_images = $productionImages;
        $order->save();

        // Notify customer if requested
        if ($request->notify_customer) {
            try {
                Notification::send($order->user, new OrderProductionUpdate($order, end($productionImages)));
            } catch (\Exception $e) {
                \Log::error('Failed to send production update notification: ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Production image uploaded successfully.');
    }

    /**
     * Delete a production image.
     */
    public function deleteImage(Order $order, $index)
    {
        $productionImages = $order->production_images ?? [];

        if (isset($productionImages[$index])) {
            // Delete the file
            Storage::disk('public')->delete($productionImages[$index]['path']);

            // Remove from array
            unset($productionImages[$index]);

            // Reindex array
            $productionImages = array_values($productionImages);

            $order->production_images = $productionImages;
            $order->save();

            return redirect()->route('admin.orders.show', $order)
                ->with('success', 'Production image deleted successfully.');
        }

        return redirect()->route('admin.orders.show', $order)
            ->with('error', 'Production image not found.');
    }

    /**
     * Generate an invoice for the order.
     */
    public function generateInvoice(Order $order)
    {
        $order->load(['user', 'items.artwork']);

        // Here you would typically use a PDF generation library
        // For example, using Laravel's built-in view to PDF with a package like barryvdh/laravel-dompdf

        // For demonstration, we'll just return a view
        return view('admin.orders.invoice', compact('order'));
    }

    /**
     * Apply filters for order listing.
     */
    public function filter(Request $request)
    {
        // Handle AJAX requests for order filtering
        // This can return JSON data for dynamic filtering
        $query = Order::with(['user']);

        // Apply filters (similar to index method)
        // ...

        $orders = $query->paginate(15);

        return response()->json([
            'orders' => $orders
        ]);
    }
}
