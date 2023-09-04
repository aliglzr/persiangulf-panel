<?php

namespace App\Http\Livewire\Profile\Agent\Plans;

use App\Models\Option;
use App\Models\Plan;
use App\Models\PlanUser;
use App\Models\Subscription;
use App\Models\TrafficUsage;
use App\Models\User;
use App\Notifications\SubscriptionNotifications\ReservedSubscriptionNotification;
use App\Notifications\SubscriptionNotifications\StartSubscriptionNotification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Component;
use TheSeer\Tokenizer\Exception;

class RenewSubscription extends Component {
    public ?User $client = null;
    public string $plan_user_id = '';
    public ?PlanUser $planUser = null;
    public Collection $planUsers;

    protected $listeners = [
        'setUser'
    ];

    public function mount() {
        $this->planUsers = Collection::make([]);
    }

    public function setUser(User $user) {
        $this->client = $user;
        $this->planUsers = \App\Models\PlanUser::getActivePlanUsers($user->introducer);
        $this->dispatchBrowserEvent('reloadSelect2');
        $this->dispatchBrowserEvent('toggleRenewSubscriptionModal');
    }

    public function resetModal() {
        $this->client = null;
        $this->planUser = null;
    }

    public function rules(): array {
        if ($this->client) {
            return [
                'plan_user_id' => ['required', 'numeric']
            ];
        } else {
            return [
                'plan_user_id' => ['required', 'numeric', Rule::in($this->planUsers->pluck('id')->toArray())]
            ];
        }
    }

    public function renewSubscription() {
        if (empty(Option::get('register_clients_status'))) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'در حال حاضر امکان خرید اشتراک موقتا غیر فعال است .']);
            return;
        }
        $this->validate($this->rules());
        if (!is_null($this->client->getReservedSubscription())) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'امکان خرید اشتراک  مشتری به دلیل داشتن اشتراک به صورت رزرو وجود ندارد']);
            return;
        }
        if ($this->client->hasActiveSubscription() && !Option::get('buy_subscription_in_reserved')) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'امکان خرید اشتراک موقتاً غیر فعال است', 'timeOut' => 5000]);
            return;
        }
        $this->planUser = PlanUser::find($this->plan_user_id);
        if (is_null($this->planUser)) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'طرح مورد نظر یافت نشد']);
            return;
        }
        if ($this->planUser->user_id != auth()->user()->id) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'طرح مورد نظر یافت نشد']);
            return;
        }
        if ($this->planUser->remaining_user_count == 0) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'طرح مورد نظر به اتمام رسیده است، جهت تمدید مشتری لطفا نسبت به خرید طرح اقدام فرمایید']);
            return;
        }

        try {
            DB::transaction(function () {
                $this->updatePlanUser();
                $this->updateClient();
                $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'اشتراک کاربر مورد نظر خریداری شد']);
                $this->dispatchBrowserEvent('toggleRenewSubscriptionModal');
            });
        } catch (Exception|\Throwable $exception) {
            \Log::critical($exception);
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'خطای سامانه، لطفا مورد را با پشتیبانی درمیان بگذارید']);
        }
    }

    /**
     * decrease remaining_user_count of the selected planUser
     */
    private function updatePlanUser() {
        $this->planUser->decrement('remaining_user_count');
        $this->planUser->save();
    }


    public function render() {
        return view('livewire.profile.agent.plans.renew-subscription');
    }

    /**
     * create Subscription for client, if the
     */
    private function updateClient() {
        $using = !$this->client->hasActiveSubscription();
        if ($using) {
            $this->client->subscriptions()->update(['using' => false]);
        }
        /** @var Subscription $newSubscription */
        $newSubscription = $this->client->subscriptions()->create([
            'starts_at' => $using ? now() : null,
            'ends_at' => $using ? now()->addDays($this->planUser->plan_duration) : null,
            'remaining_traffic' => $this->planUser->plan_traffic,
            'total_traffic' => $this->planUser->plan_traffic,
            'duration' => $this->planUser->plan_duration,
            'plan_user_id' => $this->planUser->id,
            'using' => $using]);
        if ($using) {
            // Here a subscription is activated for user, and it's not reserved
            $this->client->resetTrafficAndActiveConnections();
        }
        if ($this->client->hasVerifiedEmail()) {
            // Notify user that a new subscription has been activated
            if ($using) {
                $this->client->notify(new StartSubscriptionNotification($newSubscription));
            } else {
                $this->client->notify(new ReservedSubscriptionNotification($newSubscription));
            }
        }
    }

}
