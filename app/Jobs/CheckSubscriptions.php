<?php

namespace App\Jobs;

use App\Models\ClientTraffic;
use App\Models\Inbound;
use App\Models\Layer;
use App\Models\User;
use App\Notifications\SubscriptionNotifications\EndSubscriptionNotification;
use App\Notifications\SubscriptionNotifications\StartSubscriptionNotification;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckSubscriptions
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
                $inbound->clientTraffics()->whereRaw('(up + down > total and total > 0) or (expiry_time > 0 and expiry_time < ?)', [now()->getTimestampMs()])->get()->each(function (ClientTraffic $clientTraffic) {
                    $uuid = preg_replace("/^\d+-/", '', $clientTraffic->email);
                    $client = User::where('uuid', $uuid)->first();
                    /** @var User $client */
                    if ($client) {
                        $subscription = $client->subscriptions()->where('total_traffic',$clientTraffic->total)->where('using',true)->first();
                        if (!$subscription){
                            return;
                        }
                        $subscription->update(['using'=>false,'ends_at' => now()]);
                        // If subscription ended since remaining traffic is equal to zero
                        if ($client->hasVerifiedEmail()){
                            $timeEnd = true;
                            if ($clientTraffic->up + $clientTraffic->down >= $clientTraffic->total)
                                $timeEnd = false;
                            $client->notify(new EndSubscriptionNotification($subscription, $timeEnd));
                        }
                        $reservedSub = $client->getReservedSubscription();
                        if ($reservedSub){
                            try {
                                DB::transaction(function () use ($reservedSub,$client){
                                    $reservedSub->using = true;
                                    $reservedSub->ends_at = now()->addDays($reservedSub->duration);
                                    $reservedSub->starts_at = now();
                                    $reservedSub->save();
                                });
                                $client->resetTrafficAndActiveConnections();
                                // Notify user that a new subscription has been activated
                                if ($client->hasVerifiedEmail()){
                                    $client->notify(new StartSubscriptionNotification($reservedSub));
                                }
                                activity('فعالسازی اشتراک رزرو')->event('active reserve')->causedByAnonymous()->performedOn($reservedSub->client)->withProperties(['reservedSub' => $reservedSub->toArray(),'client' => $reservedSub->client->toArray()])->log('فعالسازی اشتراک رزرو برای کاربر'.$reservedSub->client->username);
                            }catch (\Exception | \Throwable $exception){
                                Log::critical($exception);
                            }
                        }
                    }
                });
            });
        });
    }
}
