<?php

namespace App\Http\Livewire\Profile\Client;

use App\Jobs\V2ray\ResetTraffic;
use App\Jobs\V2ray\ResetTrafficAndActiveConnections;
use App\Models\User;
use Livewire\Component;

class Navbar extends Component
{
    public User $user;

    public function mount(User $user){
        $this->user = $user;
    }

    public function login()
    {
        if(auth()->user()->isManager() || (auth()->user()->isAgent() && $this->user->reference_id == auth()->id())) {
            auth()->logout();
            auth()->loginUsingId($this->user->id);
            $this->redirect('/');
        }
    }

    public function activeConnection(): void
    {
        $this->user->activeConnections();
        $this->dispatchBrowserEvent('alert',['type' => 'success', 'message' => 'اشتراک کاربر با موفقیت فعال شد.']);
    }

    public function render()
    {
        return view('livewire.profile.client.navbar');
    }
}
