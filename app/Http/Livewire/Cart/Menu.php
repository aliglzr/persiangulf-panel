<?php

namespace App\Http\Livewire\Cart;

use App\Models\Cart;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Menu extends Component
{
    public Collection $carts;

    protected $listeners = [ 'updateCart' , 'removeFromCart' ];

    public function updateCart(){
        $this->carts = auth()->user()->cart()->get();
    }

    public function emptyCart(){
        auth()->user()->cart()->get()->each(function (Cart $cart){
            $this->emit('removedFromCart'.$cart->plan->id);
            $cart->delete();
        });
        $this->dispatchBrowserEvent('alert',['type' => 'info', 'message' => 'سبد خرید خالی شد.']);
        $this->carts = auth()->user()->cart()->get();
    }

    public function removeFromCart(int $id){
        $cart = auth()->user()->cart()->find($id);
        if ($cart){
            $this->emit('removedFromCart'.$cart->plan->id);
            $cart->delete();
        }
        $this->dispatchBrowserEvent('alert',['type' => 'info', 'message' => 'طرح از سبد خرید حذف شد']);
        $this->updateCart();
    }

    public function mount(){
        $this->carts = auth()->user()->cart()->get();
    }

    public function render()
    {
        return view('livewire.cart.menu');
    }
}
