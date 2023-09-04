<?php


namespace App\Notifications\Channels;



use Illuminate\Notifications\Notification;

class DatabaseChannel
{
    /**
     * @throws \Exception MethodDoesNotExistException
     */
    public function send($notifiable, Notification $notification){
        if (!method_exists($notification,'toArray'))
            throw new \Exception('toArray method does not exists on notification class');

        $data = $notification->toArray($notifiable);
        $notifiable->notifications()->create([
            'id' => uuid_create(),
            'type' => get_class($notification),
            'data' => $data,
            'read_at' => null,
        ]);
    }
}
