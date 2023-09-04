<?php

namespace App\Notifications\UsersNotifications;

use App\Models\Option;
use App\Notifications\Channels\DatabaseChannel;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyEmailNotification extends VerifyEmail implements ShouldBroadcast,ShouldQueue
{
    use Queueable;
    public function viaQueues()
    {
        return [
            'mail' => 'usersNotifications',
        ];
    }

    /**
     * Determine which connections should be used for each notification channel.
     *
     * @return array
     */
    public function viaConnections()
    {
        return [
            'mail' => 'redis',
            DatabaseChannel::class => 'sync',
            'broadcast' => 'sync'
        ];
    }

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [DatabaseChannel::class,'broadcast','mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        applyDynamicHost(Option::get('APP_URL'));
        $unsubscribeLink = $notifiable->generateUnsubscribeLink();
        return (new MailMessage)
            ->subject('تایید پست الکترونیکی')
            ->replyTo('no-reply@solidvpn.org', config('app.name'))
            ->withSymfonyMessage(function ($message) use ($unsubscribeLink) {
                $message->getHeaders()->addTextHeader('List-Unsubscribe',"<$unsubscribeLink>");
            })
            ->view('emails.users.verify-email',['unsubscribeLink' => $unsubscribeLink,'url' => $this->verificationUrl($notifiable)]);
    }



    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' => 'تایید آدرس ایمیل',
            'body' => 'لطفا به ایمیل خود مراجعه کرده، و روی لینک تایید حساب کاربری کلیک کنید',
            'toast_type' => 'warning',
        ];
    }
}
