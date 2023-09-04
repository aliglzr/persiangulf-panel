<?php

namespace App\Notifications\UsersNotifications;

use App\Models\Option;
use App\Notifications\Channels\DatabaseChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailChangedNotification extends Notification implements ShouldQueue,ShouldBroadcast
{
    use Queueable;

    public function viaQueues()
    {
        return [
            'mail' => 'usersNotifications',
        ];
    }

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct() {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable) {
        return ['mail', DatabaseChannel::class, 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable) {
        applyDynamicHost(Option::get('APP_URL'));
        $unsubscribeLink = $notifiable->generateUnsubscribeLink();
        return (new MailMessage)
            ->subject('آدرس پست الکترونیکی شما تغییر یافت')
            ->replyTo('no-reply@solidvpn.org', config('app.name'))
            ->withSymfonyMessage(function ($message) use ($unsubscribeLink) {
                $message->getHeaders()->addTextHeader('List-Unsubscribe', "<$unsubscribeLink>");
            })->view('emails.users.email-changed',['unsubscribeLink' => $unsubscribeLink,'user' => $notifiable]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable) {
        $email = $notifiable->email;
        return [
            'title' => 'تغییر آدرس ایمیل',
            'body' => "ایمیل شما با موفقیت به $email تغییر یافت",
            'toast_type' => 'success',
            'link' => getRequestUri($notifiable->getProfileLink())
        ];
    }
}
