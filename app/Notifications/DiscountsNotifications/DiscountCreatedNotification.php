<?php

namespace App\Notifications\DiscountsNotifications;

use App\Models\Discount;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DiscountCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public function viaQueues()
    {
        return [
            'mail' => 'notifications',
        ];
    }

    public Discount $discount;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Discount $discount)
    {
        $this->discount = $discount;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if (!$notifiable->wantToReceiveEmail('discount_email_notification')) {
            return [];
        }
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->view('emails.discounts.discount-created',['user' => $notifiable , 'discount' => $this->discount]);
    }
}
