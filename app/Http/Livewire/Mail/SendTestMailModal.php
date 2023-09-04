<?php

namespace App\Http\Livewire\Mail;

use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Qoraiche\MailEclipse\Facades\MailEclipse;

class SendTestMailModal extends Component
{

    public string $recipientMail = '';
    public string $name = '';

    public function mount(string $name){
        $this->name = $name;
    }

    public function rules(){
        return [
            'recipientMail' => ['nullable','email','max:255'],
        ];
    }

    public function updated($field){
        $this->validateOnly($field,$this->rules());
    }


    public function sendTest()
    {
        $this->validate($this->rules());

        if ($this->name === '') {
            $this->dispatchBrowserEvent('alert',['type' => 'error','message' => 'ایمیل انتخابص نشده است']);
            return;
        }


        $email = $this->recipientMail ?? config('maileclipse.test_mail');

        MailEclipse::sendTest($this->name, $email);
        $this->dispatchBrowserEvent('alert',['type' => 'success','message' => 'ایمیل ارسال شد']);
        $this->dispatchBrowserEvent('toggleSendTestMailModal');
    }

    public function resetModal(){
        $this->resetValidation();
        $this->recipientMail = '';
    }

    public function render()
    {
        return view('livewire.mail.send-test-mail-modal');
    }
}
