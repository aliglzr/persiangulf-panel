<?php

namespace App\Http\Livewire\Cart;

use App\Models\Cart;
use Livewire\Component;

class MenuItem extends Component
{
    public Cart $cart;

    public function mount(Cart $cart){
        $this->cart = $cart;
    }

    public function render()
    {
        return view('livewire.cart.menu-item');
    }
}
