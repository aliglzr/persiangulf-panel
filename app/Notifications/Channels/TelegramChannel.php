<?php


namespace App\Notifications\Channels;


use App\Core\Extensions\Telegram\Bot\Api;
use App\Models\Option;
use Exception;
use Illuminate\Notifications\Notification;
use Telegram\Bot\Exceptions\TelegramSDKException;

class TelegramChannel
{
    public Api $bot;

    /**
     * @throws Exception TelegramSDKException
     */
    public function __construct()
    {
        $this->bot = new Api(Option::get('sales_bot_token') ?? config('services.telegram-bot-api.token'));
    }

    /**
     * @throws Exception MethodDoesNotExistException
     */
    public function send($notifiable, Notification $notification): void
    {
        if (!method_exists($notification, 'toTelegram'))
            throw new Exception('toTelegram method does not exists on notification class');

        $data = $notification->toTelegram();
        $this->bot->sendMessage($data);
    }

}
