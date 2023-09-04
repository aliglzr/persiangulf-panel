<?php

namespace App\Http\Livewire\Domain;

use App\Models\Domain;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class Delete extends Component
{
    public ?Domain $domain = null;
    protected $listeners = ['deleteDomain' => 'setDomain'];

    public function setDomain(int $id){
        $this->domain = Domain::find($id);
        $this->dispatchBrowserEvent('toggleDeleteDomainModal');
    }

    public function mount(){
        $this->domain ??= new Domain();
    }

    public function deleteDomain(){
            activity("حذف دامنه")->by(auth()->user())->on($this->domain)->event("حذف دامنه")->withProperties(['domain' => $this->domain])->log('حذف دامنه');
            $this->domain->delete();
            $this->dispatchBrowserEvent('toggleDeleteDomainModal');
            $this->dispatchBrowserEvent('alert', ['type' => 'info' , 'message' => 'دامنه حذف شد']);
    }
    public function resetDeleteModal(){
        $this->resetValidation();
        $this->domain = null;
    }


    public function render()
    {
        return view('livewire.domain.delete');
    }
}
