<?php

namespace App\Http\Livewire\Profile\Client\Subscriptions;

use App\Models\Plan;
use App\Models\PlanUser;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Livewire\Component;

class SubscriptionItem extends Component {
    public Subscription $subscription;
    public User $user;
    public int $remainingPercent = 0;
    public bool $reserved = false;

    protected function getListeners() {
        return [
            "updateSubscription" => 'updateSubscription'
        ];
    }

    public function updateSubscription(int $subscriptionId) {
        if ($this->subscription->id == $subscriptionId) {
            $remainingTraffic = $this->subscription->total_traffic - $this->subscription->client->trafficUsage();
            if ($remainingTraffic) {
                $this->remainingPercent = ($remainingTraffic * 100) / $this->subscription->total_traffic;
            } else{
                $this->emit('updateSubscriptions');
                }
            }
    }

    public function mount(Subscription $subscription, User $user,bool $reserved = false) {
        $this->subscription = $subscription;
        $this->user = $user;
        $this->reserved = $reserved;
        $this->remainingPercent = ($this->subscription->remaining_traffic * 100) / $this->subscription->total_traffic;
    }

    public function getRemainingTrafficProperty(): float|int {
        return ($this->subscription->remaining_traffic * 100) / $this->subscription->total_traffic;
    }

    public function render() {
        return view('livewire.profile.client.subscriptions.subscription-item');
    }
}
