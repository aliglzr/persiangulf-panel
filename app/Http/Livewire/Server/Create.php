<?php

namespace App\Http\Livewire\Server;

use App\Models\Layer;
use App\Models\Server;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class Create extends Component
{
    public Server $server;
    public bool $editMode = false;
    protected $listeners = ['editServer' => 'editMode'];
    public int $bandwidth = 0;

    public function mount(){
        $this->server = new Server();
        $this->server->active = true;
        $this->server->available = true;
    }

    public function rules(): array
    {
        return [
            'server.name' => ['required','string','max:32'],
            'server.ip_address' => ['required','ip'],
            'server.max_connections' => ['required','numeric'],
            'bandwidth' => ['required','numeric'],
            'server.private_key' => ['nullable','string','max:255'],
            'server.public_key' => ['nullable','string','max:255'],
            'server.city' => ['required','string','max:32'],
            'server.country_id' => ['required','numeric','exists:countries,id'],
            'server.layer_id' => ['required','numeric','exists:layers,id'],
            'server.description' => ['nullable','string','max:1000'],
            'server.active' => ['required','boolean'],
            'server.available' => ['required','boolean']
        ];
    }

    public function editMode(int $id){
        $this->server = Server::find($id);
        $this->bandwidth = $this->server->bandwidth / (1024 * 1024 * 1024);
        $this->dispatchBrowserEvent('toggleServerModal');
        $this->dispatchBrowserEvent('setSelectValues',['country_id' => $this->server->country_id , 'layer_id' => $this->server->layer->id]);
        $this->editMode = true;
    }

    public function updated($field){
        $this->validateOnly($field,$this->rules());
    }

    public function create(){
        $this->validate($this->rules());
        $this->server->bandwidth = $this->bandwidth * (1024 * 1024 * 1024);
        $this->server->save();
        $this->dispatchBrowserEvent('alert',['type' => 'success', 'message' => $this->editMode ? 'سرور با موفقیت ویرایش شد' : 'سرور با موفقیت ثبت شد']);
        $this->dispatchBrowserEvent('toggleServerModal');
        $this->resetModal();
        $this->emit('update-server');
    }

    public function resetModal(){
        $this->resetValidation();
        $this->server = new Server();
        $this->server->active = true;
        $this->server->available = true;
        $this->bandwidth = 0;
        $this->editMode = false;
    }


    public function render()
    {
        return view('livewire.server.create');
    }
}
