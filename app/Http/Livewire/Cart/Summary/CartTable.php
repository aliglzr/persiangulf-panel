<?php

namespace App\Http\Livewire\Cart\Summary;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class CartTable extends Component
{
    public Collection $carts;

    protected $listeners = [ 'updateCart' ];

    public function updateCart(){
        $this->carts = auth()->user()->cart()->get();
    }

    public function mount(){
        $this->carts = auth()->user()->cart()->get();
    }

    public function render()
    {
        return view('livewire.cart.summary.cart-table');
    }
}
