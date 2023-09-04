<?php

namespace App\Events;

use App\Models\AuthToken;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TelegramLoginCode implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $code;
    public string $token;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(AuthToken $authToken)
    {
        $this->code = $authToken->code;
        $this->token = $authToken->token;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel
     */
    public function broadcastOn(): Channel
    {
        return new Channel('LoginWithTelegram.' . $this->code);
    }

    public function broadcastWith(): array
    {
        return
            [
                "code" => $this->code,
                "token" => $this->token
            ];
    }
}
