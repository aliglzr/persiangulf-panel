<?php

namespace App\Http\Livewire\Layer;

use App\Models\Layer;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class Create extends Component
{
    public Layer $layer;
    public bool $editMode = false;
    protected $listeners = ['editLayer' => 'editMode'];

    public function mount(){
        $this->layer = new Layer();
        $this->layer->active = true;
    }

    public function rules(): array
    {
        return [
            'layer.name' => ['required','string','max:60'],
            'layer.load' => ['required','numeric'],
            'layer.max_client' => ['required','numeric'],
            'layer.db_name' => ['required','string','max:255'],
            'layer.db_username' => ['required','string','max:255'],
            'layer.db_hostname' => ['required','string','max:255'],
            'layer.db_port' => ['required','numeric','max:65535'],
            'layer.db_password' => ['required','string','max:255'],
            'layer.active' => ['required','boolean'],
        ];
    }

    public function editMode(int $id){
        $this->layer = Layer::find($id);
        $this->dispatchBrowserEvent('toggleLayerModal');
        $this->editMode = true;
    }

    public function updatedLayerMaxClient($value){
        $value = preg_replace('/[^0-9.]/', '', $value);
        $this->layer->max_client = number_format($value);
    }

    public function updated($field){
        $this->validateOnly($field,$this->rules());
    }

    public function create(){
        $this->layer->max_client = preg_replace('/[^0-9.]/', '', $this->layer->max_client);
        $this->validate($this->rules());
        $this->layer->save();
        activity("ثبت لایه")->by(auth()->user())->on($this->layer)->event("ثبت لایه")->withProperties(['layer' => $this->layer])->log('ثبت لایه جدید');
        $this->dispatchBrowserEvent('alert',['type' => 'success', 'message' => $this->editMode ? 'لایه با موفقیت ویرایش شد' : 'لایه با موفقیت ثبت شد']);
        $this->dispatchBrowserEvent('toggleLayerModal');
        $this->resetModal();
    }

    public function resetModal(){
        $this->resetValidation();
        $this->layer = new Layer();
        $this->layer->active = 1;
        $this->editMode = false;
    }


    public function render()
    {
        return view('livewire.layer.create');
    }
}
