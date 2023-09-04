<?php

namespace App\Http\Livewire\Payment\Actions;

use App\Models\Payment;
use App\Models\Ticket;
use Livewire\Component;

class CheckoutPayment extends Component
{

    public function checkoutPayment(Payment $payment) {
        if (!auth()->user()->isManager()){
            return;
        }
        if ($payment->checkout){
            $this->dispatchBrowserEvent('alert',['type' => 'warning' , 'message' => 'این پرداخت تسویه شده است']);
            return ;
        }
        $payment->checkout = true;
        $payment->save();
        $this->dispatchBrowserEvent('updateTable');
        $this->dispatchBrowserEvent('alert',['type' => 'success','message' => 'پرداخت تسویه شد']);
    }

    public function render()
    {
        return view('livewire.payment.actions.checkout-payment');
    }
}
