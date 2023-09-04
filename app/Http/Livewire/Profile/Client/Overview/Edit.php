<?php

namespace App\Http\Livewire\Profile\Client\Overview;

use App\Models\User;
use App\Notifications\UsersNotifications\ChangeEmailNotification;
use App\Notifications\UsersNotifications\VerifyEmailNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Lukeraymonddowning\Honey\Traits\WithHoney;
use Lukeraymonddowning\Honey\Traits\WithRecaptcha;

class Edit extends Component
{
    use WithHoney, WithRecaptcha;

    public User $user;
    public string $password = '';
    public ?string $email = '';
    public string $password_confirmation = '';

    public function mount(User $user)
    {
        $this->user = $user;
        $this->email = $user->email;
    }

    public function rules()
    {
        return [
            'user.first_name' => ['required', 'string'],
            'user.last_name' => ['nullable', 'string'],
            'email' => ['nullable', 'string', Rule::unique('users', 'email')->ignore($this->user->id)],
            'password' => ['nullable', Password::min(6)],
            'password_confirmation' => ['nullable', 'string']
        ];
    }

    public function updated($field)
    {
            $this->validateOnly($field, $this->rules());
    }

    public function edit()
    {
        $this->validate($this->rules());
        if (!empty($this->password) || !empty($this->password_confirmation)) {
            if ($this->password_confirmation != $this->password) {
                throw ValidationException::withMessages([
                    'password_confirmation' => 'گذر واژه و تکرار آن باید مانند هم باشد'
                ]);
            } else {
                $this->validateOnly('password', $this->rules());
                $this->validateOnly('password_confirmation', $this->rules());
                $this->user->password = bcrypt($this->password);
            }
        }
        if (!empty($this->email) && $this->email != $this->user->email){
            if (auth()->user()->isManager()){
                $this->user->email = $this->email;
                $this->user->email_verified_at = now();
            }
            else{
                if ($this->user->hasVerifiedEmail()){
                    $this->user->setData('temp_mail',$this->email);
                    $this->user->notify(new ChangeEmailNotification());
                    $current_email = $this->user->email;
                    $this->dispatchBrowserEvent('alert',['type'=> 'info','message' => "ایمیل حاوی لینک تایید تغییر ایمیل، به آدرس $current_email ارسال شد، لطفا ایمیل خود را چک کرده و تایید کنید",'timeOut' => 15000]);
                }else{
                    $this->user->email = $this->email;
                    $this->user->save();
                    $this->user->notify(new VerifyEmailNotification());
                    $this->dispatchBrowserEvent('alert',['type' => 'info', 'message' => 'ایمیل حاوی لینک تایید حساب برای ایمیل وارد شده، ارسال شد.']);
                }
            }
        }
        $this->user->save();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'اطلاعات با موفقیت ویرایش شد']);
    }

    public function render()
    {
        return view('livewire.profile.client.overview.edit');
    }
}
