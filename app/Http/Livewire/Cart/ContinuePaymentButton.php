<?php

namespace App\Http\Livewire\Cart;

use Livewire\Component;

class ContinuePaymentButton extends Component
{
    protected $listeners = [
        'updateCart' => '$refresh'
    ];
    public function render()
    {
        return view('livewire.cart.continue-payment-button');
    }
}
