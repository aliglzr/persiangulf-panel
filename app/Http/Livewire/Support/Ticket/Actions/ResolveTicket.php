<?php

namespace App\Http\Livewire\Support\Ticket\Actions;

use App\Models\Ticket;
use Livewire\Component;

class ResolveTicket extends Component
{



    public function toggleResolvingTicket(Ticket $ticket) {
        if (!$ticket->user->id == auth()->user()->id && !auth()->user()->hasRole('support')){
            return;
        }
        if ($ticket->isClosed() || $ticket->isLocked()){
            $this->dispatchBrowserEvent('alert',['type' => 'warning' , 'message' => 'این تیکت بسته یا قفل شده است']);
            return ;
        }
        $ticket->closeAsResolved();
        $this->dispatchBrowserEvent('updateTable');
        $this->dispatchBrowserEvent('alert',['type' => 'success','message' => 'وضعیت تیکت به حل شده تغییر یافت']);
    }

    public function render()
    {
        return view('livewire.support.ticket.actions.resolve-ticket');
    }
}
