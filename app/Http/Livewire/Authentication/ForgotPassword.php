<?php

namespace App\Http\Livewire\Authentication;

use App\Models\User;
use App\Notifications\UsersNotifications\PasswordResetNotification;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Lukeraymonddowning\Honey\Traits\WithHoney;


class ForgotPassword extends Component
{
    public string $email = '';
    public string $token = '';
    public string $password = '';
    public string $passwordConfirm = '';
    public string $step = 'email-input';
    private null|User $user = null;


    public function tokenExists(): bool
    {
        $reset = DB::table('password_resets')->where(['email'=> $this->email])->first();
        if(!$reset){
            return false;
        }
        if(Hash::check($this->token, $reset->token)){
            return true;
        }
        return false;
    }

    public function rules()
    {
        return [
            'email' => ['required', 'email'],
        ];
    }

    public function mount() {
        if (!$this->tokenExists()){
            $this->email = '';
            $this->token = '';
        } else {

            $this->step = 'change-password';
        }

    }


    /**
     * check the inputs and rate limiting, if user found with the email we send an email,
     * if user not found we although alert success message , cause we do not want that
     * user can guest what emails is in our database
     * @return void|null
     */
    public function sendRecoveryEmail()
    {
        $this->validate($this->rules());

        if ($this->ensureIsNotRateLimited()) {
            return;
        }
        /** @var User $user */
        $user = User::where('email', $this->email)->orWhere('username', $this->email)->first();
        if ($user && $user->hasVerifiedEmail()) {
            $token = Password::createToken($user);
            if ($token) {
                $user->notify(new PasswordResetNotification($token));
            }
        }
        $this->step = 'email-sent';
        RateLimiter::hit($this->throttleKey(), 600);
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return bool
     *
     */
    public function ensureIsNotRateLimited(): bool
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 3)) {
            return false;
        }
        $user = User::where('email', $this->email)->first();
        if ($user) {
            activity('request_reset_password')->causedByAnonymous()->performedOn($user)->withProperties(['ip_address', request()->ip()])->event('request_reset_password')->log('درخواست بازگردانی رمز عبور');
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        $this->addError('email', trans('auth.reset_password', [
            'seconds' => convertNumbers($seconds),
            'minutes' => convertNumbers(ceil($seconds / 60)),
        ]));
        return true;
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey(): string
    {
        return request()->ip();
    }


    public function changePassword() {
        $this->validate([
            'password' => ['required', 'min:6', 'max:60'],
            'passwordConfirm' => ['required', 'min:6', 'max:60'],
        ]);

        if($this->password != $this->passwordConfirm) {
            $this->addError('passwordConfirm', 'گذرواژه وارد شده با تکرار آن مطابقت ندارد،');
        }

        $status = Password::reset(
            [
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->passwordConfirm,
                'token' => $this->token
            ],
            function ($user) {
                $user->forceFill([
                    'password'       => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if($status) {
            $this->step = 'password-changed';
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'کاربر گرامی، با عرض پوزش در هنگام ایجاد گذرواژه جدید شما خطایی رخ داد لطفاً مجدد سعی نمایید.', 'timeOut' => '8000']);
        }
    }



    public function render()
    {
        return view('livewire.authentication.forgot-password')->layout('auth.layout');
    }
}
