<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $statusMap = [
            'pending' => 'is pending confirmation',
            'processing' => 'is being processed',
            'in_production' => 'is in production',
            'ready_to_ship' => 'is ready to ship',
            'shipped' => 'has been shipped',
            'delivered' => 'has been delivered',
            'canceled' => 'has been canceled'
        ];

        $statusText = $statusMap[$this->order->status] ?? 'has been updated';

        $message = (new MailMessage)
            ->subject('Your Order #' . $this->order->order_number . ' Status Updated')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your order #' . $this->order->order_number . ' ' . $statusText . '.');

        if ($this->order->status === 'shipped' && $this->order->tracking_number) {
            $message->line('Your order has been shipped with ' . $this->order->carrier . '.')
                ->line('Tracking Number: ' . $this->order->tracking_number);
        }

        if ($this->order->status === 'canceled') {
            $message->line('If you have any questions about the cancellation, please contact our customer service.');
        }

        return $message
            ->line('Thank you for shopping with us!')
            ->action('View Order Details', url('/client/orders/' . $this->order->id));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'status' => $this->order->status,
            'message' => 'Your order #' . $this->order->order_number . ' status has been updated to ' . ucwords(str_replace('_', ' ', $this->order->status)),
            'tracking_number' => $this->order->tracking_number,
            'carrier' => $this->order->carrier,
        ];
    }
}
