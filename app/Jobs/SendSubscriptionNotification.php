<?php

namespace App\Jobs;

use App\Models\ClientTraffic;
use App\Models\Inbound;
use App\Models\Layer;
use App\Models\Subscription;
use App\Models\User;
use App\Notifications\SubscriptionNotifications\TimeSubscriptionNotification;
use App\Notifications\SubscriptionNotifications\TrafficSubscriptionNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class SendSubscriptionNotification
{
    use Dispatchable, SerializesModels;

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
                $inbound->clientTraffics()->whereRaw('(up + down > (0.8 * total) and total > 0 and up + down < total) or (expiry_time > 0 and expiry_time < ? and expiry_time > ?)', [now()->addDay()->getTimestampMs(),now()->getTimestampMs()])->get()->each(function (ClientTraffic $clientTraffic) {
                    $uuid = preg_replace("/^[\d]+-/", '', $clientTraffic->email);
                    $client = User::where('uuid', $uuid)->first();
                    /** @var User $client */
                    /** @var Subscription $subscription */
                    if ($client) {
                        $subscription = $client->subscriptions()->where('time_notification',false)->orWhere('traffic_notification',false)->where('total_traffic',$clientTraffic->total)->where('using',true)->first();
                        if (!$subscription){
                            return;
                        }
                        if (!$subscription->traffic_notification && ($clientTraffic->up + $clientTraffic->down > 0.8 * $clientTraffic->total)){
                            if ($client->hasVerifiedEmail()){
                                $client->notify(new TrafficSubscriptionNotification($subscription));
                            }
                            $subscription->traffic_notification = true;
                            $subscription->save();
                        }
                        if (!$subscription->time_notification && ($clientTraffic->expiry_time < now()->addDay()->getTimestampMs())){
                            if ($client->hasVerifiedEmail()){
                                $client->notify(new TimeSubscriptionNotification($subscription));
                            }
                            $subscription->time_notification = true;
                            $subscription->save();
                        }
                    }
                });
            });
        });
    }
}
