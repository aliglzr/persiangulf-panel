<?php

namespace App\Http\Livewire\Plan\Management;

use App\Models\Plan;
use App\Models\PlanUser;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;
use PragmaRX\Google2FA\Google2FA;

class ChangePrice extends Component
{
    public string $percent = '';
    public string $mode = 'increase';
    public array $modes = ['increase','decrease'];
    protected Google2FA $google2FA;
    public string $two_factor = '';

    public function rules(){
        return [
            'percent' => ['required','numeric'],
            'two_factor' => ['required','numeric','digits:6'],
            'mode' => ['string','required',Rule::in($this->modes)]
        ];
    }

    public function attributes(){
        return [
            'percent' => 'درصد',
            'two_factor' => 'کد احراز هویت دو عاملی',
        ];
    }

    public function resetModal(){
        $this->two_factor = '';
        $this->percent = '';
        $this->mode = 'increase';
    }

    public function updated($field){
        $this->validateOnly($field,$this->rules(),attributes:$this->attributes());
    }

    /**
     * @throws \Throwable
     */
    public function changePrice(){
        $this->validate($this->rules(),attributes: $this->attributes());
        if (!auth()->user()->isManager()){
            return;
        }
        $this->google2FA ??= new Google2FA();
        if (!auth()->user()->has2faEnabled() || !$this->google2FA->verify($this->two_factor,auth()->user()->getData('2fa_secret'))) {
            $this->addError('two_factor','کد تایید معتبر نیست');
            return;
        }
        try {
            DB::transaction(function (){
                Plan::all()->each(function (Plan $plan){
                    if ($this->mode == 'increase'){
                        $plan->price = $plan->price + (($plan->price * $this->percent) / 100);
                        $plan->sell_price = $plan->sell_price + (($plan->sell_price * $this->percent) / 100);
                    }else if($this->mode == 'decrease'){
                        $plan->price = $plan->price - (($plan->price * $this->percent) / 100);
                        $plan->sell_price = $plan->sell_price - (($plan->sell_price * $this->percent) / 100);
                    }
                    $plan->save();
                });
                /** @var User $solidSales */
                $solidSales = User::where('username','solidvpn_sales')->first();
                $solidPlans = PlanUser::where('user_id',$solidSales?->id)->get();
                if ($solidPlans->count() > 0){
                    $solidPlans->each(function (PlanUser $planUser){
                        if ($this->mode == 'increase'){
                            $planUser->plan_sell_price = $planUser->plan_sell_price + (($planUser->plan_sell_price * $this->percent) / 100);
                        }elseif ($this->mode == 'decrease'){
                            $planUser->plan_sell_price = $planUser->plan_sell_price - (($planUser->plan_sell_price * $this->percent) / 100);
                        }
                        $planUser->save();
                    });
                }
                $this->dispatchBrowserEvent('alert',['type' => 'success','message' => 'قیمت ها با موفقیت افزایش یافت']);
                activity('افزایش قیمت')->event('increasePrice')->causedBy(auth()->user())->withProperties(['percent' => $this->percent])->log('افزایش قیمت طرح و اشتراک های مستقیم');
                $this->dispatchBrowserEvent('toggleChangePriceModal');
            });
        }catch (\Exception $exception){
            \Log::critical($exception);
            $this->dispatchBrowserEvent('alert',['type' => 'error','message' => 'خطا در افزایش قیمت']);
        }
    }
    public function render()
    {
        return view('livewire.plan.management.change-price');
    }
}
