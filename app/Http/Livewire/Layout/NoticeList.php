<?php

namespace App\Http\Livewire\Layout;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class NoticeList extends Component
{
    public array|null $viewedNotices = null;
    public Collection $notices;
    public User $user;

    protected $listeners = ['updateNotices'];

    public function mount()
    {
        $this->notices = Collection::make([]);
        $this->viewedNotices = json_decode(auth()->user()->getData('viewed_notices'));
        $this->notices = \App\Models\Notice::where('active',true)->get()->filter(function (\App\Models\Notice $notice) {
            if (!empty($this->viewedNotices) && in_array($notice->id, $this->viewedNotices)) {
                return false;
            } else if (!empty($notice->roles) && !in_array(auth()->user()->getRole(), $notice->roles)) {
                return false;
            } else if (!empty($notice->roles) && auth()->user()->getRole() == 'client' && in_array('client', $notice->roles) && !empty($notice->layers) && !in_array(auth()->user()->layer_id, $notice->layers)) {
                return false;
            }else if(empty($notice->roles) && !empty($notice->layers) && auth()->user()->getRole() == 'client' && !in_array(auth()->user()->layer_id, $notice->layers)){
                return false;
            }else if( $notice->have_sub && auth()->user()->isClient() && !auth()->user()->hasActiveSubscription() ){
                return false;
            }
            else {
                return true;
            }
        });
    }

    public function updateNotices()
    {
        $this->notices = \App\Models\Notice::where('active',true)->get()->filter(function (\App\Models\Notice $notice) {
            if (!empty($this->viewedNotices) && in_array($notice->id, $this->viewedNotices)) {
                return false;
            } else if (!empty($notice->roles) && !in_array(auth()->user()->getRole(), $notice->roles)) {
                return false;
            } else if (!empty($notice->roles) && auth()->user()->getRole() == 'client' && in_array('client', $notice->roles) && !empty($notice->layers) && !in_array(auth()->user()->layer_id, $notice->layers)) {
                return false;
            } else {
                return true;
            }
        });
    }

    public function render()
    {
        return view('livewire.layout.notice-list');
    }
}
