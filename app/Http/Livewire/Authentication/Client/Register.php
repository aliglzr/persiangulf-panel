<?php

namespace App\Http\Livewire\Authentication\Client;

use App\Models\Layer;
use App\Models\Option;
use App\Models\User;
use App\Notifications\UsersNotifications\VerifyEmailNotification;
use App\Notifications\UsersNotifications\WelcomeNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Register extends Component
{
    public User $user;
    public string $password = '';
    public string $step = 'register';
    public string $invite_code = '';

    public function mount()
    {
        $this->user ??= new User();
    }

    public function rules()
    {
        return [
            'user.first_name' => ['required', 'string', 'max:50'],
            'user.last_name' => ['nullable', 'string', 'max:50'],
            'user.username' => ['required', 'min:5', 'max:15', 'regex:/^[\w-]*$/', 'unique:users,username'],
            'password' => ['required', 'min:6', 'max:60'],
            'user.email' => ['required', 'regex:/^[\w\@\.-]*$/', 'email', 'unique:users,email', 'max:255'],
            'invite_code' => ['nullable', 'min:6', 'max:6', 'regex:/^[\w-]*$/', 'exists:users,invite_code'],
        ];
    }

    public function register()
    {
        $this->validate($this->rules());

        if (is_null(Layer::getClientLayer())) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'کاربر گرامی، با عرض پوزش در حاضر امکان ثبت نام وجود ندارد.']);
            return;
        }

        if (empty(\App\Models\Option::get('register_clients_status'))) {
            $this->dispatchBrowserEvent('alert', ['type' => 'info', 'message' => 'کاربر گرامی، با عرض پوزش در حاضر امکان ثبت نام وجود ندارد.', 'timeOut' => '8000']);
            return;
        }

        try {
            $solidSale = User::where('username', 'solidvpn_sales')->first();
            if (!is_null($solidSale)) {
                $this->user->reference_id = $solidSale->id;
            } else {
                $this->dispatchBrowserEvent('alert', ['type' => 'info', 'message' => 'با عرض پوزش، در حال حاضر امکان ثبت نام در سایت وجود ندارد', 'timeOut' => '8000']);
                return;
            }
            if (!empty($this->invite_code)) {
                /** @var User $inviterUser */
                $inviterUser = User::where('invite_code', $this->invite_code)->first();
                $this->user->invited_by = $inviterUser->id;
                if ($inviterUser->isAgent()) {
                    $this->user->reference_id = $inviterUser->id;
                }
            }
            \DB::transaction(function () {
                $this->user->password = bcrypt($this->password);
                $this->user->layer_id = Layer::getClientLayer()->id;
                $this->user->invite_code = User::generateInviteCode();
                $this->user->save();
                $this->user->assignRole('client');
                $this->user->setData('email_subscription', true);
                $this->user->notify(new VerifyEmailNotification());
                $this->step = 'verify-mail';
            });

        } catch (\Exception | \Throwable $exception) {
            $this->dispatchBrowserEvent('alert', ['type' => 'info', 'message' => 'متاسفانه در روال ثبت نام خطایی پیش آمده است، ضمن عذرخواهی از مشکل پیش آمده، از صبر و شکیبایی شما تا رفع آن متشکریم', 'timeOut' => '8000']);
        }
    }

    public function render()
    {
        return view('livewire.authentication.client.register')->layout('auth.layout');
    }

}
