<?php

namespace App\Http\Livewire\Payment\Actions;

use App\Models\Payment;
use Illuminate\Validation\Rule;
use Livewire\Component;

class CheckoutPayments extends Component
{
    public array $operations = ['checkout'];
    public string $operation = 'checkout';

    public function rules(): array
    {
        return [
          'operation' => ['required','string',Rule::in($this->operations)]
        ];
    }

    public function run(array $payments){
        $this->validate($this->rules());
        if (count($payments) <= 0){
            $this->dispatchBrowserEvent('alert',['type' => 'error', 'message' => 'پرداختی انتخاب نشده است']);
            return;
        }
        switch ($this->operation){
            case 'checkout' : {
                foreach ($payments as $payment){
                    $payment = Payment::find($payment);
                    /** @var Payment $payment */
                    if ($payment){
                        $payment->checkout = true;
                        $payment->save();
                    }
                }
                $this->dispatchBrowserEvent('updateTable');
                $this->dispatchBrowserEvent('alert',['type' => 'success','message' => 'پرداخت ها تسویه شد.']);
            }
        }
    }


    public function render()
    {
        return view('livewire.payment.actions.checkout-payments');
    }
}
