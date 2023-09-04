<?php

namespace App\Http\Livewire\Cart\Summary;

use App\Models\Cart;
use Livewire\Component;

class CartTableItem extends Component
{
    public Cart $cart;

    public function mount(Cart $cart){
        $this->cart = $cart;
    }

    public function render()
    {
        return view('livewire.cart.summary.cart-table-item');
    }

    public function removeFromCart(){
        auth()->user()->cart()->where('plan_id',$this->cart->plan->id)->delete();
        if (auth()->user()->cart()->count() == 0){
            $this->redirect(route('plans.buy'));
        }else{
            $this->dispatchBrowserEvent('alert',['type' => 'info', 'message' => 'طرح از سبد خرید حذف شد']);
            $this->emit('updateCart');
        }

    }
}
