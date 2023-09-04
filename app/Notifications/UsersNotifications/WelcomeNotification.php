<?php

namespace App\Notifications\UsersNotifications;

use App\Models\Option;
use App\Models\Payment;
use App\Notifications\Channels\DatabaseChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification implements ShouldBroadcast,ShouldQueue
{
    use Queueable;

    public string $password = '';

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
    public function __construct(string $password)
    {
        $this->password = $password;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','broadcast',DatabaseChannel::class];
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
        return (new MailMessage)
            ->subject('به SolidVPN خوش آمدید!')
            ->replyTo('no-reply@solidvpn.org', config('app.name'))
            ->withSymfonyMessage(function ($message) use ($unsubscribeLink) {
                $message->getHeaders()->addTextHeader('List-Unsubscribe', "<$unsubscribeLink>");
            })
            ->view('emails.users.welcome', ['user' => $notifiable , 'unsubscribeLink' => $unsubscribeLink,'password' => $this->password]);
    }

//    /**
//     * Get the array representation of the notification.
//     *
//     * @param  mixed  $notifiable
//     * @return array
//     */
    public function toArray($notifiable)
    {
        return [
            'title' => 'خوش آمدید',
            'body' => 'متن توضیحات',
            'toast_type' => 'success',
        ];
    }
}
