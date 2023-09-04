<?php

namespace App\Http\Livewire\System\Options;

use App\Models\Option;
use Livewire\Component;

class TutorialLinks extends Component
{
    public string $android_tutorial_route = '';
    public string $ios_tutorial_route = '';
    public string $mac_os_tutorial_route = '';
    public string $windows_tutorial_route = '';
    public string $linux_tutorial_route = '';
    public string $about_us_route = '';
    public string $download_android_application_direct_route = '';
    public string $download_android_application_play_store_route = '';
    public string $tutorial_link = '';


    public function mount(){
        $this->android_tutorial_route = Option::get('android_tutorial_route') ?? '';
        $this->ios_tutorial_route = Option::get('ios_tutorial_route') ?? '';
        $this->mac_os_tutorial_route = Option::get('mac_os_tutorial_route') ?? '';
        $this->windows_tutorial_route = Option::get('windows_tutorial_route') ?? '';
        $this->linux_tutorial_route = Option::get('linux_tutorial_route') ?? '';
        $this->download_android_application_direct_route = Option::get('download_android_application_direct_route') ?? '';
        $this->download_android_application_play_store_route = Option::get('download_android_application_play_store_route') ?? '';
        $this->tutorial_link = Option::get('tutorial_link') ?? '';
        $this->about_us_route = Option::get('about_us_route') ?? '';

    }

    public function rules(){
        return [
            'android_tutorial_route' => ['string', 'nullable', 'max:255'],
            'ios_tutorial_route' => ['string', 'nullable', 'max:255'],
            'mac_os_tutorial_route' => ['string', 'nullable', 'max:255'],
            'windows_tutorial_route' => ['string', 'nullable', 'max:255'],
            'linux_tutorial_route' => ['string', 'nullable', 'max:255'],
            'about_us_route' => ['string', 'nullable', 'max:255'],
            'download_android_application_direct_route' => ['string', 'nullable', 'max:255'],
            'download_android_application_play_store_route' => ['string', 'nullable', 'max:255'],
            'tutorial_link' => ['nullable', 'string'],
        ];
    }

    public function save()
    {
        $this->validate($this->rules());
        Option::set('android_tutorial_route',$this->android_tutorial_route);
        Option::set('ios_tutorial_route',$this->ios_tutorial_route);
        Option::set('mac_os_tutorial_route',$this->mac_os_tutorial_route);
        Option::set('windows_tutorial_route',$this->windows_tutorial_route);
        Option::set('linux_tutorial_route',$this->linux_tutorial_route);
        Option::set('about_us_route',$this->about_us_route);
        Option::set('download_android_application_direct_route',$this->download_android_application_direct_route);
        Option::set('download_android_application_play_store_route',$this->download_android_application_play_store_route);
        Option::set('tutorial_link', $this->tutorial_link);
        $this->dispatchBrowserEvent('alert',['type' => 'success','message' => 'لینک آموزش ها با موفقیت آپدیت شد']);
    }

    public function render()
    {
        return view('livewire.system.options.tutorial-links');
    }
}
