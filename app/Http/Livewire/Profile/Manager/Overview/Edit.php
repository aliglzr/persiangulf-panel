<?php

namespace App\Http\Livewire\Profile\Manager\Overview;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Lukeraymonddowning\Honey\Traits\WithHoney;
use Lukeraymonddowning\Honey\Traits\WithRecaptcha;

class Edit extends Component
{
    use WithHoney,WithRecaptcha;
    public User $user;
    public string $password = '';
    public string $password_confirmation = '';

    public function mount(User $user){
        $this->user = $user;
    }

    public function rules(){
        return [
            'user.email' => ['required','string',Rule::unique('users','email')->ignore($this->user->id)],
            'password' => ['nullable',Password::min(8)->mixedCase()->numbers()->uncompromised()],
            'password_confirmation' => ['nullable' ,'string']
        ];
    }

    public function messages(){
        return [
            'password.numbers' => 'The :attribute must contain at least one number.',
        ];
    }

    public function updated($field)
    {
            $this->validateOnly($field, $this->rules());
    }

    public function edit(){
        $this->validate($this->rules());
        if ($this->password_confirmation != null || $this->password != null){
            if ($this->password_confirmation != $this->password){
                throw ValidationException::withMessages([
                    'password_confirmation' => 'گذر واژه و تکرار آن باید مانند هم باشد'
                ]);
            }else{
                $this->validateOnly('password',$this->rules());
                $this->validateOnly('password_confirmation',$this->rules());
                $this->user->password = bcrypt($this->password);
            }
        }
        $this->user->save();
        $this->dispatchBrowserEvent('alert',['type' => 'success' , 'message' => 'اطلاعات مدیر با موفقیت ویرایش شد']);
    }

    public function render()
    {
        return view('livewire.profile.manager.overview.edit');
    }
}
