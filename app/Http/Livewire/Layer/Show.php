<?php

namespace App\Http\Livewire\Layer;

use App\Models\Layer;
use Livewire\Component;

class Show extends Component
{
    public Layer $layer;

    public function mount(Layer $layer){
        if (!auth()->user()->can('view-server')) {
            abort(404);
        }
        $this->layer = $layer;
    }

    public function render()
    {
        return view('livewire.layer.show');
    }
}
