<?php

namespace App\Http\Livewire\Layer;

use App\Models\Layer;
use Livewire\Component;

class ClientsTable extends Component
{
    public Layer $layer;

    public function mount(Layer $layer){
        $this->layer = $layer;
    }

    public function render()
    {
        return view('livewire.layer.clients-table');
    }
}
