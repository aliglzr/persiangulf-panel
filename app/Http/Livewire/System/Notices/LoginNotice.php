<?php

namespace App\Http\Livewire\System\Notices;

use App\Models\Option;
use Illuminate\Validation\Rule;
use Livewire\Component;

class LoginNotice extends Component
{
    public string $title = '';
    public string $class = 'mb-9 p-6';
    public string $icon = '';
    public string $body = '';
    public string $button_label = '';
    public string $button_url = '';
    public string $color = 'primary';
    public array $colors = ['primary','info','secondary','warning','danger','success','dark'];
    public array $pages = ['login','register'];
    public string $padding = 'p-6';
    public string $icon_classes = 'ms-15 ms-lg-15';
    public bool $button = false;

    public function rules() : array{
        return [
            'title' => ['required','string','max:60'],
            'body' => ['required','string'],
            'icon' => ['required','string'],
            'class' => ['nullable','string'],
            'button_label' => ['required_if:button,true','string'],
            'button_url' => ['required_if:button,true','string'],
            'icon_classes' => ['nullable','string'],
            'padding' => ['nullable','string'],
            'color' => ['nullable','string',Rule::in($this->colors)],
            'button' => ['required','boolean'],
            'pages' => ['required','array'],
        ];
    }

    public function updated($field){
        $this->validateOnly($field,$this->messages(),$this->attributes());
    }

    public function mount(){
        $loginNotice = json_decode(Option::get('login_notice'),true);
        if (!empty($loginNotice)){
            $this->title = $loginNotice['title'];
            $this->class = $loginNotice['class'];
            $this->icon = $loginNotice['icon'];
            $this->body = $loginNotice['body'];
            $this->color = $loginNotice['color'];
            $this->padding = $loginNotice['padding'];
            $this->button = $loginNotice['button'];
            $this->pages = json_decode($loginNotice['pages'],true);
            if ($this->button){
                $this->button_url = $loginNotice['button_url'];
                $this->button_label = $loginNotice['button_label'];
            }
        }
    }

    public function save()
    {
        $this->validate($this->rules(),$this->messages(),$this->attributes());
        Option::set('login_notice',json_encode([
            'title' => $this->title,
            'body' => $this->body,
            'icon' => $this->icon,
            'color' => $this->color,
            'class' => $this->class,
            'icon_classes' => $this->icon_classes,
            'padding' => $this->padding,
            'button' => $this->button,
            'pages' => json_encode($this->pages),
            'button_url' => $this->button_url,
            'button_label' => $this->button_label
        ]));
        $this->dispatchBrowserEvent('alert',['type' => 'success','message' => 'اطلاعیه با موفقیت ذخیره شد']);
    }

    public function attributes(){
        return [
            'class' => 'کلاس',
            'icon' => 'آیکون',
            'body' => 'متن',
            'padding' => 'پدینگ',
            'color' => 'نوع اطلاعیه',
            'icon_classes' => 'کلاس آیکون',
            'button' => 'دکمه',
            'button_url' => 'لینک دکمه',
            'button_label' => 'متن دکمه',
        ];
    }
    public function messages(){
        return [
            'button_label.required_if' => 'متن دکمه الزامی است',
            'icon.required' => 'آیکون الزامی است',
            'button_url.required_if' => 'لینک دکمه الزامی است'
        ];
    }

    public function clear(){
        $this->reset();
        $this->resetValidation();
        Option::set('login_notice');
    }

    public function setIcon(string $icon){
        $this->icon = $icon;
    }

    public function render()
    {
        return view('livewire.system.notices.login-notice');
    }
}
