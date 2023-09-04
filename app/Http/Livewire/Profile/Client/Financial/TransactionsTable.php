<?php

namespace App\Http\Livewire\Profile\Client\Financial;

use App\Models\User;
use Livewire\Component;

class TransactionsTable extends Component
{
    public User $user;
    public function mount(User $user){
        $this->user = $user;
    }
    public function render()
    {
        return view('livewire.profile.client.financial.transactions-table');
    }
}
