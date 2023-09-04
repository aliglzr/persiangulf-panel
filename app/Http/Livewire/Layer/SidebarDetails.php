<?php

namespace App\Http\Livewire\Layer;

use App\Models\Layer;
use Livewire\Component;

class SidebarDetails extends Component
{
    public Layer $layer;

    protected $listeners = [
        'update-layer' => '$refresh'
    ];

    public function mount(Layer $layer){
        $this->layer = $layer;
    }


    public function render()
    {
        return view('livewire.layer.sidebar-details');
    }
}
