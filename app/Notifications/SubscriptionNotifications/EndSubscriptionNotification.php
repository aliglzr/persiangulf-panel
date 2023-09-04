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

class EndSubscriptionNotification extends Notification implements ShouldQueue,ShouldBroadcast
{
    use Queueable;
    public Subscription $subscription;
    public string $subscriptionName;
    public string $subscriptionDuration;
    public string $subscriptionTraffic;
    public string $endHour;
    public string $endDate;
    public bool $timeEnd;

    public function viaQueues()
    {
        return [
            'mail' => 'notifications',
        ];
    }

    /**
     * Create a new notification instance.
     *
     * @param Subscription $subscription
     * @param bool $timeEnd If its true a time end notification will send and if it's false a traffic end notification will send
     */
    public function __construct(Subscription $subscription, $timeEnd = false)
    {
        $this->subscription = $subscription;
        $this->subscriptionName = convertNumbers($this->subscription->planUser->plan_title);
        $this->subscriptionDuration = convertNumbers($this->subscription->duration);
        $this->subscriptionTraffic = convertNumbers(formatBytes($this->subscription->total_traffic));
        $this->timeEnd = $timeEnd;
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
            ->subject('اطلاعیه پایان اشتراک')
            ->mailer('no-reply')
            ->replyTo('no-reply@solidvpn.org', config('app.name'))
            ->from('no-reply@solidvpn.org', config('app.name'))
            ->withSymfonyMessage(function ($message) use ($unsubscribeLink) {
                $message->getHeaders()->addTextHeader('List-Unsubscribe',"<$unsubscribeLink>");
            })
            ->view('emails.subscriptions.end',[
                'subscription' => $this->subscription,
                'subscriptionName' => $this->subscriptionName,
                'subscriptionDuration' => $this->subscriptionDuration,
                'subscriptionTraffic' => $this->subscriptionTraffic,
                'timeEnd' => $this->timeEnd,
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
        $prefix = $this->timeEnd ? "مهلت زمانی اشتراک" : "حجم اشتراک";
        return [
            'title' => 'پایان اشتراک',
            'body' => "$prefix $this->subscriptionName $this->subscriptionTraffic $this->subscriptionDuration روزه شما به پایان رسید.",
            'toast_type' => 'warning',
            'link' => getRequestUri(route('clients.subscriptions',$notifiable))
        ];
    }

}
