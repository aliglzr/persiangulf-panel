<?php

namespace App\Http\Livewire\Support\Ticket\Actions;

use App\Models\Ticket;
use Livewire\Component;

class LockTicket extends Component
{


    public function isTicketLocked(Ticket $ticket){
        if (!$ticket->user->id == auth()->user()->id && !auth()->user()->hasRole('support')){
            return;
        }
        $this->dispatchBrowserEvent('openTicketToggleModal',['ticketId' => $ticket->id,'ticketIsLocked' => $ticket->isLocked()]);
    }

    public function toggleLockingTicket(Ticket $ticket) {
        if (!$ticket->user->id == auth()->user()->id && !auth()->user()->hasRole('support')){
            return;
        }
        if ($ticket->isClosed()){
            $this->dispatchBrowserEvent('alert',['type' => 'warning' , 'message' => 'این تیکت بسته شده است']);
            return ;
        }
        $ticket->isLocked() ? $ticket->markAsUnlocked() : $ticket->markAsLocked();
        $this->dispatchBrowserEvent('updateTable');
        $this->dispatchBrowserEvent('alert',['type' => 'success','message' => !$ticket->isLocked() ? 'قفل تیکت باز شد' : 'تیکت قفل شد']);
    }

    public function render()
    {
        return view('livewire.support.ticket.actions.lock-ticket');
    }
}
