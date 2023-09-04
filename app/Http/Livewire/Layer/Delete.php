<?php

namespace App\Http\Livewire\Layer;

use App\Models\Layer;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use PragmaRX\Google2FA\Google2FA;

class Delete extends Component
{
    public ?Layer $layer = null;
    public string $reason = '';
    public string $two_factor = '';
    protected Google2FA $google2FA;
    protected $listeners = ['deleteLayer' => 'setLayer'];

    public function setLayer(int $id){
        $this->layer = Layer::find($id);
        $this->dispatchBrowserEvent('toggleDeleteLayerModal');
    }

    public function attributes()
    {
        return [
            'reason' => 'دلیل',
            'two_factor' => 'کد تایید دوعاملی'
        ];
    }

    public function messages()
    {
        return [
            'reason.required' => ['دلیل حذف لایه الزامی است'],
            'two_factor.required' => ['فیلد کد تایید دوعاملی الزامی است'],
        ];
    }

    public function rules(){
        return [
            'reason' => ['required','string'],
            'two_factor' => ['required','numeric','digits:6']
        ];
    }

    public function updated($field){
        $this->validateOnly($field,$this->rules());
    }

    public function mount(){
        $this->layer ??= new Layer();
    }


    public function deleteLayer(){
        $this->validate($this->rules());
        $this->google2FA ??= new Google2FA();
        if (!auth()->user()->has2faEnabled() || !$this->google2FA->verify($this->two_factor,auth()->user()->getData('2fa_secret'))) {
            $this->addError('two_factor','کد تایید معتبر نیست');
        }else{
            $this->layer->disableLogging();
            activity("حذف لایه")->by(auth()->user())->on($this->layer)->event("حذف لایه")->withProperties(['layer' => $this->layer])->log($this->reason);
            $this->layer->delete();
            $this->dispatchBrowserEvent('toggleDeleteLayerModal');
            $this->dispatchBrowserEvent('alert', ['type' => 'info' , 'message' => 'لایه حذف شد']);
        }
    }
    public function resetDeleteModal(){
        $this->resetValidation();
        $this->layer = null;
        $this->reason = '';
        $this->two_factor = '';
    }


    public function render()
    {
        return view('livewire.layer.delete');
    }
}
