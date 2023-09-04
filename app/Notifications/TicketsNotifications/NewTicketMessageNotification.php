<?php

namespace App\Notifications\TicketsNotifications;

use App\Core\Extensions\Verta\Verta;
use App\Models\Message;
use App\Models\Option;
use App\Models\Ticket;
use App\Notifications\Channels\DatabaseChannel;
use Coderflex\LaravelTicket\Models\Category;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Attachment;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewTicketMessageNotification extends Notification implements ShouldQueue,ShouldBroadcast
{
    use Queueable;

    public Message $message;

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
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if (!$notifiable->wantToReceiveEmail('ticket_email_notification')) {
            return [DatabaseChannel::class, 'broadcast'];
        }
        return ['mail',DatabaseChannel::class,'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $unsubscribeLink = $notifiable->generateUnsubscribeLink();
        applyDynamicHost(Option::get('APP_URL'));
        $title = $this->message->ticket->title;
        $mailInstance = (new MailMessage)
            ->subject("پاسخ جدیدی برای تیکت شما ثبت شد : ($title)")
            ->mailer('support')
            ->from('support@solidvpn.org', config('app.name').' (Support)')
            ->replyTo('support@solidvpn.org', config('app.name').' (Support)')
            ->withSymfonyMessage(function ($message) use ($unsubscribeLink) {
                $message->getHeaders()->addTextHeader('List-Unsubscribe',"<$unsubscribeLink>");
            })->view('emails.tickets.new-ticket-message', [
                'ticket_id' => convertNumbers($this->message->ticket->ticket_id),
                'title' => $this->message->ticket->title,
                'reply' => $this->message->message,
                'category' => Category::find($this->message->ticket->category_id)->name,
                'unsubscribeLink' => $unsubscribeLink
            ]);
        return $this->message->hasMedia() ? $mailInstance->attach(Attachment::fromPath($this->message->getFirstMediaPath())) : $mailInstance;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $ticket_id = convertNumbers($this->message->ticket->ticket_id);
        return [
            'title' => "بروزرسانی وضعیت تیکت",
            'link' => getRequestUri(route('support.show',$this->message->ticket)),
            'toast_type' => 'success',
            'body' => "تیکت $ticket_id پاسخ داده شد"
        ];
    }
}
