<?php

namespace App\Http\Livewire\Server;

use App\Models\Server;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use PragmaRX\Google2FA\Google2FA;

class Delete extends Component
{
    public ?Server $server = null;
    public string $reason = '';
    public string $two_factor = '';
    protected Google2FA $google2FA;
    protected $listeners = ['deleteServer' => 'setServer'];

    public function setServer(int $id){
        $this->server = Server::find($id);
        $this->dispatchBrowserEvent('toggleDeleteServerModal');
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
            'reason.required' => ['دلیل حذف سرور الزامی است'],
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
        $this->server ??= new Server();
    }


    public function deleteServer(){
        $this->validate($this->rules());
        if (!auth()->user()->has2faEnabled()){
            $this->addError('two_factor','احراز هویت دوعاملی فعال نیست');
            return;
        }
        $this->google2FA ??= new Google2FA();
        if (!$this->google2FA->verify($this->two_factor,auth()->user()->getData('2fa_secret'))) {
            $this->addError('two_factor','کد دوعاملی معتبر نیست');
        }else{
            activity("حذف سرور")->by(auth()->user())->on($this->server)->event("حذف سرور")->withProperties(['server' => $this->server])->log($this->reason);
            $this->server->delete();
            $this->dispatchBrowserEvent('toggleDeleteServerModal');
            $this->dispatchBrowserEvent('alert', ['type' => 'info' , 'message' => 'سرور حذف شد']);
        }
    }
    public function resetDeleteModal(){
        $this->resetValidation();
        $this->server = null;
        $this->reason = '';
        $this->two_factor = '';
    }


    public function render()
    {
        return view('livewire.server.delete');
    }
}
