<?php

namespace App\Http\Livewire\Layout;

use Livewire\Component;
use Mockery\Matcher\Not;

class Notice extends Component
{
    public \App\Models\Notice $notice;
    public bool $read = false;

    public function mount(\App\Models\Notice $notice){
        $this->notice = $notice;
    }

    public function readNotice(){
        $this->read = true;
        if(!\App\Models\Notice::find($this->notice->id)) {
            return;
        }
        /** @var array|null $viewedNotices */
        $viewedNotices = json_decode(auth()->user()->getData('viewed_notices'),true);
        if (empty($viewedNotices)){
            $viewedNotices = [];
            array_push($viewedNotices,$this->notice->id);
            auth()->user()->setData('viewed_notices',json_encode($viewedNotices));
        }
        else if (!in_array($this->notice->id,$viewedNotices)){
            array_push($viewedNotices,$this->notice->id);
            auth()->user()->setData('viewed_notices',json_encode($viewedNotices));
        }
        $this->emit('updateNotices');
    }

    public function render()
    {
        return view('livewire.layout.notice');
    }
}
