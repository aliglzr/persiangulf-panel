<?php

namespace App\Http\Livewire\Domain;

use App\Models\Layer;
use App\Models\Domain;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Create extends Component
{
    public Domain $domain;
    public bool $editMode = false;
    protected $listeners = ['editDomain' => 'editMode'];

    public function mount(){
        $this->domain = new Domain();
        $this->domain->active = true;
        $this->domain->cdn = 'ac';
    }

    public function rules(): array
    {
        return [
            'domain.hostname' => ['required','string','max:32'],
            'domain.cdn' => ['required','string',Rule::in(['ac','cf'])],
            'domain.server_id' => ['required','numeric','exists:servers,id'],
            'domain.active' => ['required','boolean'],
        ];
    }

    public function editMode(int $id){
        $this->domain = Domain::find($id);
        $this->dispatchBrowserEvent('toggleDomainModal');
        $this->dispatchBrowserEvent('setSelectValues',['server_id' => $this->domain->server_id,'cdn' => $this->domain->cdn]);
        $this->editMode = true;
    }

    public function updated($field){
        $this->validateOnly($field,$this->rules());
    }

    public function create(){
        $this->validate($this->rules());
        $this->domain->save();
        $this->dispatchBrowserEvent('alert',['type' => 'success', 'message' => $this->editMode ? 'دامنه با موفقیت ویرایش شد' : 'دامنه با موفقیت ثبت شد']);
        $this->dispatchBrowserEvent('toggleDomainModal');
        $this->resetModal();
        $this->emit('update-domain');
    }

    public function resetModal(){
        $this->resetValidation();
        $this->domain = new Domain();
        $this->domain->active = true;
        $this->domain->cdn = 'ac';
        $this->editMode = false;
    }


    public function render()
    {
        return view('livewire.domain.create');
    }
}
