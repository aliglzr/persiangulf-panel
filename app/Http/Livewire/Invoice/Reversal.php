<?php

namespace App\Http\Livewire\Invoice;

use App\Models\Invoice;
use App\Models\Plan;
use App\Models\User;
use Livewire\Component;

class Reversal extends Component
{

    public function reverseInvoice(Invoice $invoice){
        // TODO : implement Reverse Invoice
        $is_allowed_to_reverse = true;
        if ($invoice->user->isClient()){
            return;
        }
        // TODO : Fix bug
        //start bug
        foreach ($invoice->user->plans()->wherePivot('invoice_id',$invoice->id)->get() as $plan){
            /** @var Plan $plan */
            if ($plan->planUser->created_at != $plan->planUser->updated_at){
                $is_allowed_to_reverse = false;
                break;
            }
        }
        //end bug
        if ($is_allowed_to_reverse){
            $invoice->user->transactions()->create([
                'amount' => $invoice->transaction->amount,
                'status' => 'paid',
                'balance_before_transaction' => $invoice->user->balance,
                'balance_after_transaction' => $invoice->user->balance + $invoice->net_amount_payable,
            ]);
            $invoice->user->increment('balance',$invoice->net_amount_payable);
            $invoice->user->plans()->detach($invoice->plans()->get()->pluck(['id'])->toArray());
            $invoice->delete();
            $this->dispatchBrowserEvent('alert',['type' => 'success','message' => 'فاکتور برگشت داده شد و به اعتبار مشتری اضافه شد']);
            $this->dispatchBrowserEvent('updateTable');
        }else{
            $this->dispatchBrowserEvent('alert', ['type'=> 'error','message' => 'امکان برگشت فاکتور وجود ندارد']);
        }
    }

    public function render()
    {
        return view('livewire.invoice.reversal');
    }
}
