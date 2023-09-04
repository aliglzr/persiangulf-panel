<?php

namespace App\Http\Livewire\Profile\Agent\Plans;

use App\Models\Inbound;
use App\Models\Layer;
use App\Models\Option;
use App\Models\PlanUser;
use App\Models\User;
use App\Notifications\SubscriptionNotifications\StartSubscriptionNotification;
use App\Notifications\UsersNotifications\VerifyEmailNotification;
use App\Notifications\UsersNotifications\WelcomeNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;

class AddSubscription extends Component {
    public ?PlanUser $planUser = null;
    public string $plan_user_id = '';
    public User $user;
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $username = '';
    public string $password = '';
    public bool $clientCreated = false;
    public bool $quickAccess = true;

    public function mount(User $user) {
        $this->user = $user;
    }

    protected $listeners = ['setPlanUser'];

    public function setPlanUser(int $planUserId) {
        $this->quickAccess = false;
        $this->planUser = PlanUser::find($planUserId);
        $this->dispatchBrowserEvent('toggleAddSubscriptionModal');
    }

    public function updated($field) {
        $this->validateOnly($field);
    }

    public function rules() {
        return [
            'first_name' => ['required','string','max:60'],
            'last_name' => ['nullable','string','max:60'],
            'email' => ['nullable','regex:/^[\w\@\.-]*$/','email','max:255','unique:users,email'],
            'plan_user_id' => [$this->quickAccess ? 'required' : 'nullable','numeric',Rule::in(\App\Models\PlanUser::getActivePlanUsers($this->user)->pluck('id')->toArray())]
        ];
    }

    public function updatedPlanUserId(){
        $this->planUser = PlanUser::find($this->plan_user_id);
    }

    /**
     * create client base on the selected plan and the client details that agent provide to us
     */
    public function createSubscription() {
        if(empty(Option::get('register_clients_status'))){
            $this->dispatchBrowserEvent('alert',['type' => 'error','message' => 'در حال حاضر امکان ثبت مشتری موقتا غیر فعال است .']);
            return ;
        }
        if (is_null($this->planUser) || $this->planUser->user_id != $this->user->id) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => $this->quickAccess ? 'طرحی انتخاب نشده است' : 'طرح مورد نظر یافت نشد']);
            return;
        }
        $this->validate($this->rules());
        if ($this->planUser->remaining_user_count == 0) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'طرح مورد نظر به اتمام رسیده است، جهت ثبت اشتراک جدید لطفا نسبت به خرید طرح اقدام فرمایید']);
            return;
        }
        if (is_null(Layer::getClientLayer())){
            $this->dispatchBrowserEvent('alert',['type' => 'error','message' => 'در حال حاضر به دلیل اتمام ظرفیت، امکان ثبت مشتری وجود ندارد.']);
            return;
        }
        try {

            DB::transaction(function (){
                $this->createClient(User::generateUsername());
                $this->clientCreated = true;
                $this->updateAgentPlanUser();
                $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'اشتراک جدید افزوده شد']);
                $this->emit('updatePlanUser', $this->planUser->id);
            });
        }catch (\Exception|\Throwable $exception){
            \Log::critical($exception);
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'خطای سامانه ۱۰۰۳، لطفا این مورد را با پشتیبانی درمیان بگذارید']);
        }
    }

    public function resetModal() {
        $this->first_name = '';
        $this->last_name = '';
        $this->email = '';
        $this->password = '';
        $this->username = '';
        $this->clientCreated = false;
        $this->planUser = null;
        $this->quickAccess = true;
        $this->resetValidation();
    }

    public function render() {
        return view('livewire.profile.agent.plans.add-subscription');
    }

    /**
     * @param string $newUsername
     *
     */
    public function createClient(string $username): void {
        /* @var User $client */
        // generate password for new client
        $this->password = User::generatePassword();

        //create client base on the inputs
        $client = User::create([
            'uuid' => \Str::uuid(),
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'username' => $username,
            'password' => bcrypt($this->password),
            'email' => empty($this->email) ? null : $this->email,
            'reference_id' => $this->user->id,
            'layer_id' => Layer::getClientLayer()->id,
            'invite_code' => User::generateInviteCode()
        ]);
        $client->setData('email_subscription',true);
        // assign client role to the new user
        $client->assignRole('client');
        // create subscription base on the selected plan
        $newSubscription = $client->subscriptions()->create([
            'starts_at' => now(),
            'ends_at' => now()->addDays($this->planUser->plan_duration),
            'total_traffic' => $this->planUser->plan_traffic,
            'duration' => $this->planUser->plan_duration,
            'plan_user_id' => $this->planUser->id,
            'using' => true,
        ]);
        $client->resetTrafficAndActiveConnections();
        //send EmailVerificationNotification & WelcomeNotification with account details if the email field filled
        if (!empty($this->email)){
            $client->notify(new VerifyEmailNotification());
            $client->notify(new WelcomeNotification($this->password));
            // Notify user that a new subscription has been activated
            $this->user->notify(new StartSubscriptionNotification($newSubscription));
        }



        // set username for showing in view for agent
        $this->username = $client->username;
    }

    /**
     *decrement plan remaing_user_count
     */
    private function updateAgentPlanUser() {
        $this->planUser->decrement('remaining_user_count');
        $this->planUser->save();
    }
}
