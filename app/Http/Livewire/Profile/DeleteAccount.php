<?php

namespace App\Http\Livewire\Profile;

use App\Models\ClientTraffic;
use App\Models\Inbound;
use App\Models\PlanUser;
use App\Models\User;
use App\Notifications\PlanUserNotifications\ReturnedSubscriptionForPlanUser;
use Illuminate\Validation\Rule;
use Livewire\Component;

class DeleteAccount extends Component
{
    public User $user;

    public string $reason = '';
    public string $delete_user = '';
    public bool $deleted = false;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->deleted = false;
    }

    public function rules()
    {
        return [
            'reason' => ['required', 'string', 'min:3'],
            'delete_user' => ['required', 'string', Rule::in('delete user')],
        ];
    }

    public function attributes()
    {
        return [
            'reason' => 'دلیل',
            'delete_user' => 'حذف کاربر'
        ];
    }

    public function messages()
    {
        return [
            'reason.required' => ['دلیل غیر فعال سازی الزامی است'],
            'delete_user.required' => ['فیلد حذف کاربر الزامی است'],
            'delete_user.in' => ['عبارت delete user به درستی وارد نشده است'],
        ];
    }

    public function updated($field)
    {
        $this->validateOnly($field, $this->rules(), $this->messages(), $this->attributes());
    }

    public function deleteUser()
    {
        if ($this->user->isManager()) {
            return;
        }
        $this->validate($this->rules(), $this->messages(), $this->attributes());
        try {
            $roleName = $this->user->roles()->first()->slug;
            \DB::transaction(function () {
                // change the first child's parent to the user parent , uf user does not have any introducer , the reference_id will be solidvpn_sales
                $redirectRoute = $this->user->isAgent() ? route('agents.index') : route('clients.index');
                if ($this->user->isAgent()) {
                    $this->user->introduced()->each(function (User $user) {
                        if ($this->user->reference_id) {
                            $user->reference_id = $this->user->reference_id;
                        } else {
                            $user->reference_id = User::where('username', 'solidvpn_sales')->first()?->id;
                        }
                        $user->save();
                    });
                } else if ($this->user->isClient()) {
                    $this->returnSubscriptionForPlanUser();
                }
                $this->user->delete();
                $this->deleted = true;
                $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'کاربر با موفقیت حذف شد', 'redirect' => $redirectRoute]);
            });
            // log the reason
            activity("حذف $roleName")->by(auth()->user())->on($this->user)->event("حذف $roleName")->withProperties(['reason' => $this->reason, 'user' => $this->user])->log(" حذف $roleName " . $this->user->username);
        } catch (\Exception | \Throwable $exception) {
            \Log::critical($exception);
            $this->dispatchBrowserEvent('alert', ['type' => 'info', 'message' => 'متاسفانه خطایی در حذف کاربر رخ داده است، لطفا مورد را با پشتیبانی درمیان بگذارید.']);
        }
    }

    public function render()
    {
        return view('livewire.profile.delete-account');
    }

    public function returnSubscriptionForPlanUser(): void
    {
        $currentSubscription = $this->user->getCurrentSubscription();
        if ($currentSubscription && $this->user->trafficUsage() == 0) {
            /** @var PlanUser $planUser */
            $planUser = PlanUser::find($currentSubscription->plan_user_id);
            $planUser->increment('remaining_user_count');
            $this->user->introducer->notify(new ReturnedSubscriptionForPlanUser($planUser, $this->user));
        }
        $reservedSubscription = $this->user->getReservedSubscription();
        if ($reservedSubscription) {
            /** @var PlanUser $planUser */
            $planUser = PlanUser::find($reservedSubscription->plan_user_id);
            $planUser->increment('remaining_user_count');
            $this->user->introducer->notify(new ReturnedSubscriptionForPlanUser($planUser, $this->user));
        }
        // Deletes all inbounds of user and resets xray
        $this->user->deleteInbounds();
    }
}
