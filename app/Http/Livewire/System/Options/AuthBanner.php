<?php

namespace App\Http\Livewire\System\Options;

use App\Models\Option;
use Illuminate\Validation\Rules\File;
use Livewire\Component;
use Livewire\WithFileUploads;

class AuthBanner extends Component
{
    public $attachment = null;
    public string $auth_page_title = '';
    public string $auth_page_subtitle = '';
    use WithFileUploads;

    public function mount(){
        $this->auth_page_title = Option::get('auth_page_title') ?? '';
        $this->auth_page_subtitle = Option::get('auth_page_subtitle') ?? '';
    }

    public function rules(){
        return [
            'auth_page_title' => ['string', 'nullable', 'max:100'],
            'auth_page_subtitle' => ['string', 'nullable', 'max:500'],
            'attachment' => [File::types(['jpeg','jpg','png','svg']),'nullable'],
        ];
    }

    public function save(){
        $this->validate($this->rules());
        Option::set('auth_page_title',$this->auth_page_title);
        Option::set('auth_page_subtitle',$this->auth_page_subtitle);
        if ($this->attachment){
            $name = md5(auth()->user()->id . time()) . '-' . time();
            $fileName = $name . '.' . $this->attachment->extension();
            $auth_banner = $this->attachment->storePubliclyAs('uploads','auth_banner.'.$this->attachment->extension(),'public');
            Option::set('auth_banner','storage/'.$auth_banner);
        }
        $this->dispatchBrowserEvent('alert',['type' => 'success','message' => 'ذخیره شد']);
    }

    public function render()
    {
        return view('livewire.system.options.auth-banner');
    }
}
