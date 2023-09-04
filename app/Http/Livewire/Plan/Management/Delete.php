<?php

namespace App\Http\Livewire\Plan\Management;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use PragmaRX\Google2FA\Google2FA;

class Delete extends Component
{
    public ?Plan $plan = null;
    public string $reason = '';
    public string $two_factor = '';
    protected Google2FA $google2FA;
    protected $listeners = ['deletePlan' => 'setPlan'];

    public function setPlan(int $id){
        $this->plan = Plan::find($id);
        $this->dispatchBrowserEvent('toggleDeletePlanModal');
    }

    public function attributes()
    {
        return [
            'reason' => 'دلیل',
            'two_factor' => 'کد تایید دوعاملی'
        ];
    }

    public function messages()
    {
        return [
            'reason.required' => ['دلیل حذف طرح الزامی است'],
            'two_factor.required' => ['فیلد کد تایید دوعاملی الزامی است'],
        ];
    }

    public function rules(){
        return [
            'reason' => ['required','string'],
            'two_factor' => ['required','numeric','digits:6']
        ];
    }

    public function updated($field){
        $this->validateOnly($field,$this->rules());
    }

    public function mount(){
        $this->plan ??= new Plan();
    }


    public function deletePlan(){
        $this->validate($this->rules());
        $this->google2FA ??= new Google2FA();
        if (!auth()->user()->has2faEnabled() || !$this->google2FA->verify($this->two_factor,auth()->user()->getData('2fa_secret'))) {
            $this->addError('two_factor','کد تایید معتبر نیست');
        }else{
            $this->plan->delete();
            $this->dispatchBrowserEvent('toggleDeletePlanModal');
            $this->dispatchBrowserEvent('alert', ['type' => 'info' , 'message' => 'طرح حذف شد']);
        }
    }
    public function resetDeleteModal(){
        $this->resetValidation();
        $this->plan = null;
        $this->reason = '';
        $this->two_factor = '';
    }


    public function render()
    {
        return view('livewire.plan.management.delete');
    }
}
