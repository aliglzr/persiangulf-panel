<?php

namespace App\Http\Controllers\Api\Application\V1;

use App\Exceptions\Api\Application\V1\NoSubscriptionException;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class UsageController extends Controller
{
    public function getUsageDetails(Request $request){
        /** @var User $user */
        $user = $request->user();
        if (is_null($user) || !$user->isClient()) {
            throw new AuthenticationException('Unauthenticated.');
        }
        if ($user->subscriptions()->count() == 0){
            throw new NoSubscriptionException();
        }
        $status = $user->trafficUsages()->latest()->first();
        $currentSubscription = $user->getCurrentSubscription();
        $total = $status?->total ?? 0;
        $download = $status?->total_traffic_received ?? 0;
        $upload = $status?->total_traffic_sent ?? 0;
        $remainingTraffic = $currentSubscription?->remaining_traffic;
        $totalTraffic = $currentSubscription?->planUser?->plan_traffic;
            return [
                'ok' => true,
                'data' => [
                    'total' => $total,
                    'download' => $download,
                    'upload' => $upload,
                    'remainingTraffic' => $remainingTraffic,
                    'totalTraffic' => $totalTraffic,
                ],
                'error' => null
            ];

    }
}
