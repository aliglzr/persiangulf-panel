<?php

namespace App\Notifications\UsersNotifications;

use App\Models\Option;
use App\Models\User;
use App\Notifications\Channels\DatabaseChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class ChangeEmailNotification extends Notification implements ShouldQueue,ShouldBroadcast
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
        return ['mail',DatabaseChannel::class,'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable) {
        /** @var User $notifiable */
        $unsubscribeLink = $notifiable->generateUnsubscribeLink();
        applyDynamicHost(Option::get('APP_URL'));
        return (new MailMessage)
            ->subject('تغییر آدرس پست الکترونیکی')
            ->replyTo('no-reply@solidvpn.org', config('app.name'))
            ->withSymfonyMessage(function ($message) use ($unsubscribeLink) {
                $message->getHeaders()->addTextHeader('List-Unsubscribe', "<$unsubscribeLink>");
            })->view('emails.users.change-email', ['unsubscribeLink' => $unsubscribeLink,'user' => $notifiable,'url' => URL::temporarySignedRoute('change.email',now()->addHours(2),['hash' => sha1($notifiable->email),'id' => $notifiable->id])]);
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
            'title' => 'ارسال لینک تایید تغییر آدرس ایمیل',
            'body' => "ایمیل حاوی لینک تغییر آدرس ایمیل به آدرس $notifiable->email ارسال شد",
            'toast_type' => 'success',
            'link' => getRequestUri($notifiable->getProfileLink())
        ];
    }
}
