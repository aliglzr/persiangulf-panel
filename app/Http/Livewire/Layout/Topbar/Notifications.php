<?php

namespace App\Http\Livewire\Layout\Topbar;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\DatabaseNotification;
use Livewire\Component;

class Notifications extends Component
{
    public User $user;
    public Collection $unreadNotifications;

    public function notifyNewNotification($data){
        $this->dispatchBrowserEvent('alert',['type' => $data['toast_type'],'message' => $data['body'] , 'timeOut' => 5000]);
        $this->unreadNotifications = $this->user->unreadNotifications()->take(10)->get();
    }

    public function markAsRead(){
        $this->user->unreadNotifications->markAsRead();
        $this->setUserNotifications();
    }

    public function mount(){
        $this->user = auth()->user();
        $this->setUserNotifications();
    }


    public function setUserNotifications(){
        $this->unreadNotifications = $this->user->unreadNotifications()->take(10)->get();
    }

    public function render()
    {
        return view('livewire.layout.topbar.notifications');
    }
}
