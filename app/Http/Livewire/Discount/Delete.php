<?php

namespace App\Http\Livewire\Discount;

use App\Models\Discount;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class Delete extends Component
{

    public function deleteDiscount(Discount $discount)
    {
        $discount->disableLogging();
        activity("حذف تخفیف")->by(auth()->user())->on($discount)->event("حذف تخفیف")->withProperties(['discount' => $discount])->log('حدف لایه');
        $discount->delete();
        $this->dispatchBrowserEvent('refreshDiscountTable');
        $this->dispatchBrowserEvent('alert', ['type' => 'info', 'message' => ' حذف شد']);
    }

    public function render()
    {
        return view('livewire.discount.delete');
    }

}
