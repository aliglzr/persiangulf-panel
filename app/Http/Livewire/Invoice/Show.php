<?php

namespace App\Http\Livewire\Invoice;

use App\Models\Invoice;
use App\Models\Option;
use Livewire\Component;

class Show extends Component
{
    public Invoice $invoice;

    public function mount(Invoice $invoice){
        if (auth()->user()->id != $invoice->user->id){
            if (!auth()->user()->can('view-invoice')){
                abort(404);
            }
        }
        if($invoice->subscription == null && $invoice->planUsers->count() == 0) {
            abort(404);
        }
        $this->invoice = $invoice;
    }

    public function render()
    {
        return view('livewire.invoice.show');
    }
}
