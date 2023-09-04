<?php

namespace App\Notifications\UsersNotifications;

use App\Core\Extensions\Verta\Verta;
use App\Models\Option;
use Coderflex\LaravelTicket\Models\Category;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordResetNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public string $token = '';

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
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }


    /**
     * Get the mail representation of the notification.
     * @param $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable){
        applyDynamicHost(Option::get('APP_URL'));
        $unsubscribeLink = $notifiable->generateUnsubscribeLink();
        return (new MailMessage)
            ->subject('بازیابی گذرواژه حساب کاربری')
            ->replyTo('no-reply@solidvpn.org', config('app.name'))
            ->withSymfonyMessage(function ($message) use ($unsubscribeLink) {
                $message->getHeaders()->addTextHeader('List-Unsubscribe',"<$unsubscribeLink>");
            })
            ->view('emails.users.reset-password',['user' => $notifiable,'token' => $this->token,'unsubscribeLink' => $unsubscribeLink]);
    }
}
