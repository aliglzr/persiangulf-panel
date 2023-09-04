<?php

namespace App\Http\Livewire\System\Notices;

use Livewire\Component;

class Delete extends Component
{
    public $notice_id;

    public function mount($notice_id)
    {
        $this->notice_id = $notice_id;
    }

    public function render()
    {
        return view('livewire.system.notices.delete');
    }
}