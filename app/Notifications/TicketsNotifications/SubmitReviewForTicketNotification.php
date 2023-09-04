<?php

namespace App\Notifications\TicketsNotifications;

use App\Models\Option;
use App\Models\Ticket;
use App\Notifications\Channels\DatabaseChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubmitReviewForTicketNotification extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable;

    public Ticket $ticket;


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
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if (!$notifiable->wantToReceiveEmail('ticket_email_notification')) {
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
            ->subject('شرکت در نظرسنجی تیکت ' . convertNumbers($this->ticket->ticket_id))
            ->mailer('no-reply')
            ->replyTo('no-reply@solidvpn.org', config('app.name'))
            ->from('no-reply@solidvpn.org', config('app.name'))
            ->withSymfonyMessage(function ($message) use ($unsubscribeLink) {
                $message->getHeaders()->addTextHeader('List-Unsubscribe',"<$unsubscribeLink>");
            })->view('emails.tickets.submit-review-for-ticket', [
                'ticket_id' => $this->ticket->ticket_id,
                'unsubscribeLink' => $unsubscribeLink
            ]);
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
            'title' => "شرکت در نظرسنجی",
            'link' => getRequestUri(route('support.show', $this->ticket->ticket_id)).'?submit_review=true',
            'toast_type' => 'info',
            'body' => "کاربر عزیز، با شرکت در نظرسنجی ما را در ارائه بهتر خدمات و پشتیبانی یاری نمایید."
        ];
    }
}
