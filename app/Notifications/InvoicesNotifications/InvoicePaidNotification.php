<?php

namespace App\Notifications\InvoicesNotifications;

use App\Models\Invoice;
use App\Models\Option;
use App\Notifications\Channels\DatabaseChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvoicePaidNotification extends Notification implements ShouldBroadcast, ShouldQueue
{
    use Queueable;

    public Invoice $invoice;


    public function viaQueues()
    {
        return [
            'mail' => 'notifications',
        ];
    }


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if (!$notifiable->wantToReceiveEmail('invoice_email_notification')) {
            return [DatabaseChannel::class, 'broadcast'];
        }
        return ['mail', DatabaseChannel::class, 'broadcast'];
    }


    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $unsubscribeLink = $notifiable->generateUnsubscribeLink();
        applyDynamicHost(Option::get('APP_URL'));
        return (new MailMessage)
            ->subject('صورتحساب خرید '.($notifiable->isAgent() ? 'طرح' : 'اشتراک'))
            ->mailer('no-reply')
            ->replyTo('no-reply@solidvpn.org', config('app.name'))
            ->from('no-reply@solidvpn.org', config('app.name'))
            ->withSymfonyMessage(function ($message) use ($unsubscribeLink) {
                $message->getHeaders()->addTextHeader('List-Unsubscribe', "<$unsubscribeLink>");
            })
            ->view('emails.invoices.invoice-paid', ['invoice' => $this->invoice , 'user' => $notifiable, 'unsubscribeLink' => $unsubscribeLink]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' => 'صورتحساب خرید '.($notifiable->isAgent() ? 'طرح' : 'اشتراک'),
            'body' => 'خرید شما با موفقیت انجام شد',
            'toast_type' => 'success',
            'link' => getRequestUri(route('invoices.show', $this->invoice))
        ];
    }


}
