<?php

namespace App\Notifications\SubscriptionNotifications;

use App\Core\Extensions\Verta\Verta;
use App\Models\Option;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Notifications\Channels\DatabaseChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReservedSubscriptionNotification extends Notification implements ShouldQueue,ShouldBroadcast
{
    use Queueable;
    public Subscription $subscription;
    public string $subscriptionName;
    public string $subscriptionDuration;
    public string $subscriptionTraffic;
    public string $endHour;
    public string $endDate;

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
    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
        $this->subscriptionName = convertNumbers($this->subscription->planUser->plan_title);
        $this->subscriptionDuration = convertNumbers($this->subscription->duration);
        $this->subscriptionTraffic = convertNumbers(formatBytes($this->subscription->total_traffic));
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if (!$notifiable->wantToReceiveEmail('subscription_email_notification')) {
           return [DatabaseChannel::class,'broadcast'];
        }
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
        $unsubscribeLink = $notifiable->generateUnsubscribeLink();
        applyDynamicHost(Option::get('APP_URL'));
        return (new MailMessage)
            ->subject('اطلاعیه رزرو اشتراک')
            ->mailer('no-reply')
            ->replyTo('no-reply@solidvpn.org', config('app.name'))
            ->from('no-reply@solidvpn.org', config('app.name'))
            ->withSymfonyMessage(function ($message) use ($unsubscribeLink) {
                $message->getHeaders()->addTextHeader('List-Unsubscribe',"<$unsubscribeLink>");
            })
            ->view('emails.subscriptions.in-reserve',[
                'subscription' => $this->subscription,
                'subscriptionName' => $this->subscriptionName,
                'subscriptionDuration' => $this->subscriptionDuration,
                'subscriptionTraffic' => $this->subscriptionTraffic,
                'unsubscribeLink' => $unsubscribeLink]);
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
            'title' => 'رزرو اشتراک',
            'body' => "اشتراک رزرو $this->subscriptionName $this->subscriptionDuration روزه $this->subscriptionTraffic ، پس از اتمام بسته فعلی به صورت خودکار فعال خواهد شد.",
            'toast_type' => 'success',
            'link' => getRequestUri(route('clients.subscriptions',$notifiable))
        ];
    }

}
