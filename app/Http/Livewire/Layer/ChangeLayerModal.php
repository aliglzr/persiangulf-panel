<?php

namespace App\Http\Livewire\Layer;

use App\Models\Layer;
use App\Models\Server;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class ChangeLayerModal extends Component
{
    public ?Model $model = null;
    public string|null $layer_id = '';
    public Collection $layers;

    protected $listeners = [
        'setModel'
    ];

    public function setModel($data){
        $type = $data['type'];
        $model_id = $data['model_id'];
        if ($type == 'server'){
            $this->model = Server::find($model_id);
        }else if($type == 'client'){
            $this->model = User::role('client')->whereId($model_id)->first();
        }else{
            $this->dispatchBrowserEvent('alert',['type' => 'error','message' => 'سرور یا مشتری پیدا نشد']);
            return;
        }
        if (is_null($this->model)){
            $this->dispatchBrowserEvent('alert',['type' => 'error','message' => 'سرور یا مشتری پیدا نشد']);
            return;
        }
        $this->dispatchBrowserEvent('toggleChangeLayerModal',['currentLayerId' => $this->model->layer_id]);
    }

    public function mount(){
        $this->updateLayers();
    }

    public function updateLayers(){
        $this->layers = Layer::where('active',true)->get();
    }

    public function rules(){
        return [
            'layer_id' => ['required','numeric','exists:layers,id']
        ];
    }

    public function changeLayer(){
        if (is_null($this->model)){
            $this->dispatchBrowserEvent('alert',['type' => 'error','message' => 'ورودی نامعتبر']);
            return;
        }
        if ($this->model->layer_id == $this->layer_id){
            $this->dispatchBrowserEvent('alert',['type' => 'info','message' => 'لطفا لایه ای متفاوت از لایه کنونی را انتخاب کنید']);
            return;
        }
        $this->validateOnly('layer_id');
        if ($this->model instanceof User){
            $this->model->deleteInbounds();
        }
        $this->model->layer_id = $this->layer_id;
        $this->model->save();
        if ($this->model instanceof User){
            $this->dispatchBrowserEvent('alert',['type' => 'success','message' => 'لایه مشتری با موفقیت تغییر یافت.']);
            $this->dispatchBrowserEvent('toggleChangeLayerModal',['refresh' => 'refreshClientTable']);
        }else if ($this->model instanceof Server){
            $this->dispatchBrowserEvent('toggleChangeLayerModal',['refresh' => 'refreshServerTable']);
        }
    }

    public function resetModal(){
        $this->resetValidation();
        $this->model = null;
        $this->layer_id = '';
        $this->updateLayers();
    }


    public function dehydrate(){
        $this->dispatchBrowserEvent('livewire:dehydrate');
    }

    public function render()
    {
        return view('livewire.layer.change-layer-modal');
    }
}
