<?php

namespace App\Http\Livewire\Profile\Agent\Financial;

use App\Models\User;
use Livewire\Component;

class InvoicesTable extends Component
{
    public User $user;
    public function mount(User $user){
        $this->user = $user;
    }
    public function render()
    {
        return view('livewire.profile.agent.financial.invoices-table');
    }
}
