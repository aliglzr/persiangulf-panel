<?php

namespace App\Http\Livewire\Plan\Management;

use App\Models\Plan;
use Livewire\Component;

class Create extends Component
{
    public Plan $plan;
    public string $traffic = '';
    public bool $editMode = false;
    public function mount(){
        $this->plan = new Plan();
        $this->plan->active = 1;
        $this->plan->only_bot = 0;
    }

    protected $listeners = ['editPlan' => 'editMode'];


    public function editMode(int $id){
        $this->plan = Plan::find($id);
        $this->traffic = $this->plan->traffic / (1024 * 1024);
        $this->dispatchBrowserEvent('togglePlanModal');
        $this->editMode = true;
    }

    public function rules(): array
    {
        return [
            'plan.title' => ['required','string','max:60'],
            'plan.description' => ['nullable','string','max:1000'],
            'plan.price' => ['required','numeric'],
            'plan.sell_price' => ['required','numeric'],
            'plan.users_count' => ['required','numeric'],
            'traffic' => ['required','numeric'],
            'plan.duration' => ['required','numeric'],
            'plan.inventory' => ['nullable','numeric'],
            'plan.active' => ['required','boolean'],
            'plan.only_bot' => ['required','boolean'],
        ];
    }

    public function updatedPlanPrice($value){
        $value = preg_replace('/[^0-9.]/', '', $value);
        $this->plan->price = number_format($value);
    }

    public function updatedPlanSellPrice($value){
        $value = preg_replace('/[^0-9.]/', '', $value);
        $this->plan->sell_price = number_format($value);
    }

    public function updated($field){
        $this->validateOnly($field,$this->rules());
    }

    public function create(){
        $this->plan->price = preg_replace('/[^0-9.]/', '', $this->plan->price);
        $this->plan->sell_price = preg_replace('/[^0-9.]/', '', $this->plan->sell_price);
        $this->validate($this->rules());
        $this->plan->traffic = $this->traffic * (1024 * 1024);
        $this->plan->save();
        $this->dispatchBrowserEvent('alert',['type' => 'success', 'message' => $this->editMode ? 'طرح با موفقیت ویرایش شد' : 'طرح با موفقیت ثبت شد']);
        $this->dispatchBrowserEvent('togglePlanModal');
        $this->resetModal();
    }

    public function resetModal(){
        $this->resetValidation();
        $this->plan = new Plan();
        $this->plan->active = 1;
        $this->plan->only_bot = 0;
        $this->traffic = 0;
        $this->editMode = false;
    }

    public function render()
    {
        return view('livewire.plan.management.create');
    }
}
