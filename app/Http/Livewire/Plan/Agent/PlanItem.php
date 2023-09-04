<?php

namespace App\Http\Livewire\Plan\Agent;

use App\Models\Cart;
use App\Models\Plan;
use App\Models\User;
use Livewire\Component;

class PlanItem extends Component
{
    public Plan $plan;
    public User $user;
    public bool $added_to_cart = false;
    protected function getListeners()
    {
        return [
            "removedFromCart{$this->plan->id}" => 'removedFromCart',
            'reset' => 'removedFromCart'
        ];
    }

    public function mount(Plan $plan)
    {
        $this->user = auth()->user();
        $this->plan = $plan;
        if ($this->user->cart()->where('plan_id',$this->plan->id)->first()){
            $this->added_to_cart = true;
        }
    }

    public function addToCart()
    {
        if ($this->user->isUserAllowedToAddToCart($this->plan)) {
            $this->user->cart()->create(['plan_id'=> $this->plan->id]);
            $this->added_to_cart = true;
            $this->emit('updateCart');
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'طرح به سبد خرید اضافه شد']);
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'info', 'message' => 'امکان اضافه کردن این طرح به سبد خرید وجود ندارد']);
        }
    }

    public function removeFromCart(){
        $cart = auth()->user()->cart()->where('plan_id',$this->plan->id)->first();
        if ($cart){
            $cart->delete();
        }
        $this->added_to_cart = false;
        $this->dispatchBrowserEvent('alert',['type' => 'info', 'message' => 'طرح از سبد خرید حذف شد']);
        $this->emit('updateCart');
    }

    public function removedFromCart(){
            $this->added_to_cart = false;
    }


    public function render()
    {
        return view('livewire.plan.agent.plan-item');
    }
}
