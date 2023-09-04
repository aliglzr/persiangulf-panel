<?php

namespace App\Http\Livewire\Layout\Agent\QuickAccess;

use App\Core\Extensions\V2ray\Models\Inbound;
use App\Models\Option;
use App\Models\PlanUser;
use App\Models\Subscription;
use App\Models\TrafficUsage;
use App\Models\User;
use App\Notifications\SubscriptionNotifications\ReservedSubscriptionNotification;
use App\Notifications\SubscriptionNotifications\StartSubscriptionNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;

class RenewSubscription extends Component {
    public string $client_id = '';
    public ?User $client = null;
    public string $planUser_id = '';
    public ?PlanUser $planUser = null;


    public function mount() {
    }


    public function resetModal() {
        $this->client = null;
        $this->planUser = null;
    }

    public function rules(): array {
        return [
            'planUser_id' => ['required', 'numeric', Rule::in(PlanUser::getActivePlanUsers(auth()->user())->pluck('id')->toArray())],
            'client_id' => ['required', 'numeric', Rule::in(auth()->user()->clients()->pluck('id')->toArray())],
        ];
    }

    public function renewSubscription() {
        if (empty(Option::get('register_clients_status'))) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'در حال حاضر امکان خرید اشتراک موقتا غیر فعال است .']);
            return;
        }
        $this->validate($this->rules());
        $this->client = User::find($this->client_id);
        $this->planUser = PlanUser::find($this->planUser_id);
        if (is_null($this->planUser) || $this->planUser->user_id != auth()->user()->id) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'طرح مورد نظر یافت نشد']);
            return;
        }
        if ($this->planUser?->remaining_user_count == 0) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'طرح مورد نظر به اتمام رسیده است، جهت تمدید مشتری لطفا نسبت به خرید طرح اقدام فرمایید']);
            return;
        }
        if (!is_null($this->client->getReservedSubscription())) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'امکان خرید اشتراک  مشتری به دلیل داشتن اشتراک به صورت رزرو وجود ندارد']);
            return;
        }
        if ($this->client->hasActiveSubscription() && !Option::get('buy_subscription_in_reserved')) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'امکان خرید اشتراک موقتا غیر فعال است', 'timeOut' => 5000]);
            return;
        }
        try {
            DB::transaction(function () {
                $this->updateUserSubscription();
                $this->updateClient();
                $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'اشتراک کاربر مورد نظر خریداری شد']);
                $this->dispatchBrowserEvent('toggleQuickAccessRenewSubscriptionModal');
            });
        } catch (\Exception|\Throwable $exception) {
            \Log::critical($exception);
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'خطای سامانه، لطفا مورد را با پشتیبانی درمیان بگذارید']);
        }
    }

    private function updateUserSubscription() {
        $this->planUser->decrement('remaining_user_count');
        $this->planUser->save();
    }


    public function render() {
        return view('livewire.layout.agent.quick-access.renew-plan-user');
    }

    private function updateClient(): void
    {
        $using = !$this->client->hasActiveSubscription();
        if ($using) {
            $this->client->subscriptions()->update(['using' => false]);
        }
        /** @var Subscription $newSubscription */
        $newSubscription = $this->client->subscriptions()->create([
            'starts_at' => !$using ? null : now(),
            'ends_at' => !$using ? null : now()->addDays($this->planUser->plan_duration),
            'total_traffic' => $this->planUser->plan_traffic,
            'plan_user_id' => $this->planUser->id,
            'using' => $using]);
        if ($using) {
            // Here a subscription is activated for user, and it's not reserved
            $this->client->resetTrafficAndActiveConnections();
        }
        // Notify user that a new subscription has been activated
        if ($this->client->hasVerifiedEmail()) {
            if ($using) {
                $this->client->notify(new StartSubscriptionNotification($newSubscription));
            } else {
                $this->client->notify(new ReservedSubscriptionNotification($newSubscription));
            }
        }
    }
}
