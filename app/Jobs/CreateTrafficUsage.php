<?php

namespace App\Jobs;

use App\Models\ClientTraffic;
use App\Models\Inbound;
use App\Models\Layer;
use App\Models\TrafficUsage;
use App\Models\User;
use App\Notifications\SubscriptionNotifications\EndSubscriptionNotification;
use App\Notifications\SubscriptionNotifications\StartSubscriptionNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateTrafficUsage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Layer::where('active', true)->get()->each(function (Layer $layer) {
            $inbounds = new Inbound();
            $inbounds = $inbounds->layer($layer->id)->getAll();
            $inbounds->each(function (Inbound $inbound) {
                $inbound->clientTraffics()->whereRaw('up + down < total and total > 0 and expiry_time > ?', [now()->getTimestampMs()])->get()->each(function (ClientTraffic $clientTraffic) {
                    $uuid = preg_replace("/^\d+-/", '', $clientTraffic->email);
                    $client = User::where('uuid', $uuid)->first();
                    /** @var User $client */
                    if ($client) {
                        if (!$client->hasActiveSubscription()){
                            return;
                        }
                        /** @var TrafficUsage|null $lastUsage */
                        $lastUsage = $client->trafficUsages()->latest()->first();
                        $total = $clientTraffic->up + $clientTraffic->down;
                        $client->trafficUsages()->create([
                            'total_traffic_sent' => $clientTraffic->up,
                            'total_traffic_received' => $clientTraffic->down,
                            'net_traffic_sent' => max($clientTraffic->up - ($lastUsage?->total_traffic_sent ?? 0), 0),
                            'net_traffic_received' => max($clientTraffic->down - ($lastUsage?->total_traffic_received ?? 0),0),
                            'total' => $total,
                            'net' => max($total - ($lastUsage?->total ?? 0), 0)
                        ]);
                    }
                });
            });
        });
    }
}
