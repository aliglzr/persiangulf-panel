<?php

namespace App\Http\Livewire\Profile\Client;

use App\Jobs\V2ray\ResetTrafficAndActiveConnections;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ResetTrafficAndActiveClientConnections extends Component
{
    public User $user;
    public string $description = '';
    public string $reset_client = '';
    public bool $reset = false;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->reset = false;
    }

    public function rules()
    {
        return [
            'description' => ['nullable', 'string', 'min:3'],
            'reset_client' => ['required', 'string', Rule::in('reset client')],
        ];
    }

    public function attributes()
    {
        return [
            'description' => 'دلیل',
            'reset_client' => 'ریست مشتری'
        ];
    }

    public function messages()
    {
        return [
            'reset_client.required' => ['فیلد ریست مشتری الزامی است'],
            'reset_client.in' => ['عبارت reset client به درستی وارد نشده است'],
        ];
    }

    public function updated($field)
    {
        $this->validateOnly($field, $this->rules(), $this->messages(), $this->attributes());
    }

    public function resetClientTraffic()
    {
        if (!auth()->user()->isManager()) {
            return;
        }
        $this->validate($this->rules(),$this->messages(),$this->attributes());
        try {
            DB::transaction(function (){
                $this->user->resetTrafficAndActiveConnections();
                activity("ریست مشتری")->by(auth()->user())->on($this->user)->event("ریست مشتری")->withProperties(['description' => $this->description, 'user' => $this->user])->log($this->description);
                $this->reset = true;
                $this->dispatchBrowserEvent('closeResetTrafficAndActiveConnectionsModal');
                $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'با موفقیت ریست شد!']);
            });
        }catch (\Exception | \Throwable $exception){
            \Log::critical($exception);
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'خطای سامانه، لطفا مورد را با پشتیبانی درمیان بگذارید']);
        }
    }

    public function render()
    {
        return view('livewire.profile.client.reset-traffic-and-active-client-connections');
    }
}
