<?php

namespace App\Notifications\PlanUserNotifications;

use App\Models\PlanUser;
use App\Models\User;
use App\Notifications\Channels\DatabaseChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReturnedSubscriptionForPlanUser extends Notification implements ShouldQueue,ShouldBroadcast
{
    use Queueable;
    public PlanUser $planUser;
    public ?User $deletedUser = null;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(PlanUser $planUser,$deletedUser = null)
    {
        $this->planUser = $planUser;
        $this->deletedUser = $deletedUser;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [DatabaseChannel::class,'broadcast'];
    }

//    /**
//     * Get the mail representation of the notification.
//     *
//     * @param  mixed  $notifiable
//     * @return \Illuminate\Notifications\Messages\MailMessage
//     */
//    public function toMail($notifiable)
//    {
//        return (new MailMessage)
//                    ->line('The introduction to the notification.')
//                    ->action('Notification Action', url('/'))
//                    ->line('Thank you for using our application!');
//    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $planUserName = convertNumbers($this->planUser->plan_title);
        $deletedUsername = $this->deletedUser?->username;
        $body = $this->deletedUser ? "اشتراک $planUserName با حذف حساب $deletedUsername به طرح شما برگشت داده شد. " : "اشتراک $planUserName به طرح شما برگشت داده شد.";
        return [
            'title' => 'برگشت اشتراک',
            'body' => $body,
            'toast_type' => 'success',
            'link' => getRequestUri(route('agents.plans',['user' => $notifiable]))
        ];
    }
}
