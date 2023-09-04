<?php

namespace App\Http\Livewire\Agent;

use App\Models\User;
use App\Notifications\UsersNotifications\VerifyEmailNotification;
use App\Notifications\UsersNotifications\WelcomeNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Create extends Component
{
    public User $user;
    public string $password = '';
    public string $password_confirmation = '';

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function rules()
    {
       return [
            'user.first_name' => ['required', 'string','max:255'],
            'user.last_name' => ['required', 'string','max:255'],
            'user.username' => ['required', 'string', Rule::unique('users', 'username'),'max:255'],
            'user.email' => ['required', 'string', Rule::unique('users', 'email'),'max:255'],
            'user.reference_id' => ['nullable' , 'numeric' , Rule::exists('users','id')],
            'password' => ['required', Password::min(8)->mixedCase()->numbers()->uncompromised(),'max:255'],
            'password_confirmation' => ['required', 'string', 'same:password']
        ];
    }

    public function updated($field)
    {
        //fix for real time validation
        $this->validateOnly($field, $this->rules());
    }

    public function create()
    {
        $this->validate($this->rules());
            if ($this->password_confirmation != $this->password) {
                throw ValidationException::withMessages([
                    'password_confirmation' => 'گذر واژه و تکرار آن باید مانند هم باشد'
                ]);
            }
        $this->user->password = bcrypt($this->password);
        $this->user->email_verified_at = now();
        $this->user->invite_code = User::generateInviteCode();
        $this->user->save();
        $this->user->assignRole('agent');
        $this->user->setData('email_subscription',true);
        $this->user->notify(new WelcomeNotification($this->password));
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'نماینده با موفقیت ایجاد شد']);
        $this->redirect(route('agents.index'));
    }

    public function render()
    {
        return view('livewire.agent.create');
    }
}
