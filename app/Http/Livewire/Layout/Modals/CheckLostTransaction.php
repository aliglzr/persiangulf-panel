<?php

namespace App\Http\Livewire\Layout\Modals;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Component;

class CheckLostTransaction extends Component
{
    public User $user;
    public string $transaction_id = '';

    public function mount(){
        $this->user = auth()->user();
    }

    public function rules(){
        return [
            'transaction_id' => ['required','string',Rule::notIn($this->user->payments()->pluck('blockchain_transaction_id')->toArray())]
        ];
    }

    public function updated($field){
        $this->validateOnly($field);
    }

    public function checkLostTransaction(){
        $this->validate($this->rules());
        // TODO : request to etherscan in order to check transaction
    }



    public function render()
    {
        return view('livewire.layout.modals.check-lost-transaction');
    }
}
