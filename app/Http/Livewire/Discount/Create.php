<?php

namespace App\Http\Livewire\Discount;

use App\Models\Discount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Create extends Component
{
    public Discount $discount;
    public bool $editMode = false;
    protected $listeners = ['editDiscount' => 'editMode'];

    public function mount(){
        $this->discount = new Discount();
        $this->discount->active = true;
        $this->discount->max = null;
    }

    public function rules(): array
    {
        return [
            'discount.code' => ['required','string',$this->editMode ? Rule::unique('discounts','code')->ignore($this->discount->id) : 'unique:discounts,code','max:32'],
            'discount.remaining_count' => ['nullable','numeric'],
            'discount.description' => ['nullable','string','max:1000'],
            'discount.percent' => ['required','numeric'],
            'discount.max' => ['nullable','numeric'],
            'discount.user_id' => ['nullable','numeric','exists:users,id'],
            'discount.plan_id' => ['nullable','numeric','exists:plans,id'],
            'discount.expires_at' => ['nullable','string'],
            'discount.active' => ['required','boolean'],
        ];
    }

    public function editMode(int $id){
        $this->discount = Discount::find($id);
        $this->dispatchBrowserEvent('toggleDiscountModal');
        $this->dispatchBrowserEvent('setSelectValues',['user_id' => $this->discount->user_id , 'plan_id' => $this->discount->plan_id]);
        $this->editMode = true;
    }

    public function updatedDiscountMax($value){
        $value = preg_replace('/[^0-9.]/', '', $value);
        $this->discount->max = number_format(floatval($value));
    }

    public function updated($field){
        $this->validateOnly($field,$this->rules());
    }

    public function create(){
        $this->discount->max = preg_replace('/[^0-9.]/', '', $this->discount->max);
        $this->validate($this->rules());
        if (is_null($this->discount->max) || $this->discount->max == ""){
            $this->discount->max = null;
        }
        $this->discount->save();
        activity("ثبت تخفیف")->by(auth()->user())->on($this->discount)->event("ثبت تخفیف")->withProperties(['discount' => $this->discount])->log("ثبت تخفیف جدید");
        $this->dispatchBrowserEvent('alert',['type' => 'success', 'message' => $this->editMode ? 'تخفیف با موفقیت ویرایش شد' : 'تخفیف با موفقیت ثبت شد']);
        $this->dispatchBrowserEvent('toggleDiscountModal');
        $this->resetModal();
    }

    public function resetModal(){
        $this->resetValidation();
        $this->discount = new Discount();
        $this->discount->max = null;
        $this->discount->active = 1;
        $this->editMode = false;
    }

    public function render()
    {
        return view('livewire.discount.create');
    }
}
