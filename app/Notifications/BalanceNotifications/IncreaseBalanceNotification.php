<?php

namespace App\Notifications\BalanceNotifications;

use App\Core\Extensions\Verta\Verta;
use App\Models\Option;
use App\Models\Payment;
use App\Models\Transaction;
use App\Notifications\Channels\DatabaseChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class IncreaseBalanceNotification extends Notification implements ShouldQueue,ShouldBroadcast
{
    use Queueable;
    public Transaction $transaction;

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
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if (!$notifiable->wantToReceiveEmail('payment_email_notification')) {
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
            ->subject('اطلاعیه افزایش اعتبار')
            ->mailer('no-reply')
            ->replyTo('no-reply@solidvpn.org', config('app.name'))
            ->from('no-reply@solidvpn.org', config('app.name'))
            ->withSymfonyMessage(function ($message) use ($unsubscribeLink) {
                $message->getHeaders()->addTextHeader('List-Unsubscribe',"<$unsubscribeLink>");
            })
            ->view('emails.balance.increase-balance',['transaction' => $this->transaction, 'payment' => $this->transaction->payment, 'unsubscribeLink' => $unsubscribeLink]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $transactionAmount = convertNumbers(number_format($this->transaction->amount));
        return [
            'title' => 'افزایش اعتبار',
            'body' => "اعتبار شما به میزان $transactionAmount تومان افزایش یافت ",
            'toast_type' => 'success',
            'link' => getRequestUri(route('payments.show',[$this->transaction->payment]))
        ];
    }

}
