<?php

namespace App\Http\Livewire\Mail;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Livewire\Component;
use Qoraiche\MailEclipse\Facades\MailEclipse;

class CreateMailable extends Component
{

    public string $name = '';

    public bool $force = false;

    public function rules(){
        return [
            'name' => ['required','string'],
            'force' => ['boolean']
        ];
    }

    public function updated($field){
        $this->validateOnly($field,$this->rules());
    }

    public function create(){
        $this->validate($this->rules());
        $parameters = $this->commandParameters(['name' => $this->name,'force' => $this->force]);

        $name = MailEclipse::generateClassName($parameters['name']);
        $defaultDirectory = 'Mail';

        $mailableDir = config('maileclipse.mailables_dir');
        $customPath = substr($mailableDir, strpos($mailableDir, $defaultDirectory) + strlen($defaultDirectory) + 1);



        if (strtolower($parameters['name']) === 'mailable') {
            $this->addError('name','این نام رزرو شده است');
            return ;
        }

        if (! MailEclipse::getMailable('name', $parameters['name'])->isEmpty() && !$parameters['force']) {
            $this->addError('name','ایمیلی با همین عنوان وجود دارد و عنوان ایمیل نباید تکراری باشد. در صورت نیاز به رونوشت، الزام به ساخت ایمیل را تیک بزنید');
            return ;
        }

        $name = $customPath ? $customPath.'/'.$name : $name;

        $params = collect([
            'name' => $name,
        ]);

         if ($parameters['force']) {
             $params->put('--force', true);
         }

        $exitCode = Artisan::call('make:mail', $params->all());

        if ($exitCode > -1) {
            $this->dispatchBrowserEvent('alert',['type' => 'success','message' => 'ایمیل ایجاد شد']);
            $this->dispatchBrowserEvent('toggleCreateMailableModal');
            return ;
        }
        $this->dispatchBrowserEvent('alert',['type' => 'error','message' => 'ساخت ایمیل با خطا مواجه شد']);
    }

    /**
     * Get the parameters for the artisan command.
     *
     * @param  array  $parameters
     * @return array
     */
    protected function commandParameters(array $parameters)
    {
        $parameters['name'] = ucwords(Str::camel(preg_replace('/\s+/', '_', $parameters['name'])));


        return $parameters;
    }

    public function resetModal(){
        $this->resetValidation();
        $this->name = '';
        $this->force = false;
    }

    public function render()
    {
        return view('livewire.mail.create-mailable');
    }
}
