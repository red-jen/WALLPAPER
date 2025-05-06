<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderProductionUpdate extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;
    protected $productionImage;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order, array $productionImage)
    {
        $this->order = $order;
        $this->productionImage = $productionImage;
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
        $stageMap = [
            'initial_setup' => 'Initial Setup',
            'printing' => 'Printing Process',
            'quality_check' => 'Quality Check',
            'finishing' => 'Finishing Touches',
            'packaging' => 'Packaging',
            'ready_to_ship' => 'Ready to Ship'
        ];

        $stageName = $stageMap[$this->productionImage['stage']] ?? 'Production Update';

        return (new MailMessage)
            ->subject('Production Update for Order #' . $this->order->order_number)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('We have an exciting update on your order #' . $this->order->order_number . '!')
            ->line('Your order has reached the "' . $stageName . '" stage of production.')
            ->line('We\'ve attached a photo so you can see the progress.')
            ->line($this->productionImage['note'] ?? '')
            ->action('View Order Details', url('/client/orders/' . $this->order->id))
            ->line('Thank you for your patience as we craft your custom order with care.');
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
            'production_stage' => $this->productionImage['stage'],
            'production_note' => $this->productionImage['note'] ?? null,
            'image_path' => $this->productionImage['path'],
            'message' => 'New production update for order #' . $this->order->order_number . ': ' .
                ucwords(str_replace('_', ' ', $this->productionImage['stage'])),
        ];
    }
}
