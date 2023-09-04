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

class TrafficSubscriptionNotification extends Notification implements ShouldQueue,ShouldBroadcast
{
    use Queueable;
    public Subscription $subscription;
    public string $subscriptionName;
    public string $subscriptionDuration;
    public string $subscriptionTraffic;
    public string $subscriptionRemainedTraffic;
    public string $nowHour;
    public string $nowDate;

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
        $this->subscriptionRemainedTraffic = convertNumbers(formatBytes($this->subscription->remaining_traffic));
        $this->nowHour = Verta::now()->persianFormat('H:i:s');
        $this->nowDate = Verta::now()->persianFormat('Y/m/d');
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
            ->subject('اطلاعیه حجم اشتراک')
            ->mailer('no-reply')
            ->replyTo('no-reply@solidvpn.org', config('app.name'))
            ->from('no-reply@solidvpn.org', config('app.name'))
            ->withSymfonyMessage(function ($message) use ($unsubscribeLink) {
                $message->getHeaders()->addTextHeader('List-Unsubscribe',"<$unsubscribeLink>");
            })
            ->view('emails.subscriptions.traffic',[
                'subscription' => $this->subscription,
                'subscriptionName' => $this->subscriptionName,
                'subscriptionDuration' => $this->subscriptionDuration,
                'subscriptionTraffic' => $this->subscriptionTraffic,
                'subscriptionRemainedTraffic' => $this->subscriptionRemainedTraffic,
                'nowDate' => $this->nowDate,
                'nowHour' => $this->nowHour,
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
            'title' => 'حجم اشتراک',
            'body' => "شما تا ساعت $this->nowHour تاریخ $this->nowDate بیش از ۸۰ درصد از حجم بسته $this->subscriptionName $this->subscriptionTraffic $this->subscriptionDuration روزه را مصرف کرده اید و تنها $this->subscriptionRemainedTraffic از حجم اشتراک شما باقی مانده است.",
            'toast_type' => 'warning',
            'link' => getRequestUri(route('clients.subscriptions',$notifiable))
        ];
    }

}
