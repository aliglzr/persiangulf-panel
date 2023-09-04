<?php

namespace App\Notifications\TicketsNotifications;

use App\Models\Message;
use App\Models\Option;
use App\Models\Ticket;
use App\Notifications\Channels\DatabaseChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Attachment;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewTicketNotification extends Notification implements ShouldQueue, ShouldBroadcast {
    use Queueable;

    public Ticket $ticket;

    public Message $message;


    public function viaQueues() {
        return [
            'mail' => 'notifications',
        ];
    }

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Ticket $ticket) {
        $this->ticket = $ticket;
        $this->message = $ticket->messages()->first();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable) {
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
    public function toMail($notifiable) {
        $title = $this->ticket->title;
        $subject = "تیکت شما دریافت شد: ($title)";

        $unsubscribeLink = $notifiable->generateUnsubscribeLink();
        applyDynamicHost(Option::get('APP_URL'));
        $mailInstance = (new MailMessage)
            ->subject($subject)
            ->mailer('support')
            ->from('support@solidvpn.org', config('app.name').' (Support)')
            ->replyTo('support@solidvpn.org', config('app.name').' (Support)')
            ->withSymfonyMessage(function ($message) use ($unsubscribeLink) {
                $message->getHeaders()->addTextHeader('List-Unsubscribe', "<$unsubscribeLink>");
            })->view('emails.tickets.new-ticket', ['ticket' => $this->ticket, 'reply' => $this->message, 'user' => $notifiable, 'unsubscribeLink' => $unsubscribeLink]);
         return $this->message->hasMedia() ? $mailInstance->attach(Attachment::fromPath($this->message->getFirstMediaPath())) : $mailInstance;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable): array {
        $ticket_id = $this->ticket->ticket_id;
        return [
            'title' => 'ثبت تیکت جدید',
            'body' => "تیکت شما با شماره " . convertNumbers($ticket_id) . " دریافت شد.",
            'toast_type' => 'success',
            'link' => getRequestUri(route('support.show', $this->ticket))
        ];
    }
}
