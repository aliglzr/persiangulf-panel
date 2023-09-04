<?php

namespace App\Http\Livewire\Authentication;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;
use Livewire\Component;
use PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException;
use PragmaRX\Google2FA\Exceptions\InvalidCharactersException;
use PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException;
use PragmaRX\Google2FA\Google2FA;

class Login extends Component
{


    public string $username = '';
    public string $password = '';
    public string $step = 'login';
    public string $google2FA_code = '';
    public bool $is_2fa_activated = false;
    public string $recovery_code = '';
    public bool $recovery_mode = false;
    public User|null $user = null;
    public ?string $intendedPath = null; // store intendedPath that comes from previous route
    public string $redirectPath = '/'; // the path that user should redirectTo after successful login

    public string $resetEmail = '';
    public string $resetToken = '';

    public string $message = '';

    protected $queryString = [
        'resetEmail' => ['except' => '', 'as' => 'email'],
        'resetToken' => ['except' => '', 'as' => 'token'],
        'message' => ['except' => '', 'as' => 'message'],
    ];



    public function tokenExists(): bool
    {
        $reset = DB::table('password_resets')->where(['email'=> $this->resetEmail])->first();
        if(!$reset){
            return false;
        }
        if(Hash::check($this->resetToken, $reset->token)){
            return true;
        }
        return false;
    }

    public function mount()
    {
        if (!$this->tokenExists()){
            $this->resetEmail = '';
            $this->resetToken = '';
        } else{
            $this->step = 'reset-password';
        }
        $this->redirectPath = session('intendedPath') ?? '/';
    }

    protected array $rules = [
        'username' => ['required', 'string'],
        'password' => ['required', 'min:6'],
        'google2FA_code' => ['required', 'min:6', 'max:6'],
        'recovery_code' => ['required', 'string'],
    ];

    /**
     * handle login logic
     */
    public function login()
    {
        if (!$this->isNotRateLimited())
            return;

        $this->user = User::where('username', $this->username)->first();

        if (!is_null($this->user) && !$this->user->active) {
            RateLimiter::hit($this->throttleKey());
            $this->addError('username', 'حساب کاربری غیر فعال شده است');
            return;
        }

        // if the user does not pass validation, RateLimiter will hit and throw an error
        if (!$this->checkCredentials($this->user)) {
            RateLimiter::hit($this->throttleKey());
            $this->addError('username', __('auth.failed'));
            return;
        }

        // If manager does not have 2FA enabled , prevent from logging in to the panel
        // except when the application is in debug mode
        //region 2FA Enabled
        if (!$this->user->has2faEnabled() && $this->user->isManager() && !config('app.debug')) {
            $this->addError('username', __('auth.failed'));
//                throw ValidationException::withMessages([__('auth.failed')]);
        }
        //endregion
        if (!config('app.debug') && $this->user->has2faEnabled()) {
            $this->is_2fa_activated = true;
            return;
        }
        $this->generateSessionAndLogin($this->user);
    }


    public function returnToLogin()
    {
        $this->google2FA_code = '';
        $this->is_2fa_activated = false;
        $this->recovery_code = '';
        $this->step = 'login';
        $this->recovery_mode = false;
        $this->user = null;
    }

    public function goToRegister() {
        $this->step = 'register';
    }

    public function resetPassword() {
        $this->step = 'reset-password';
    }

    public function loginWithTelegram() {
        $this->step = 'login-with-telegram';
    }

    public function loginWithGoogle(): void
    {
        $this->redirect(Socialite::driver('google')->with(['redirect_uri' => "https://". \request()->getHttpHost() . config('services.google.redirect')])->stateless()->redirect()->getTargetUrl());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return bool
     *
     */
    public function isNotRateLimited(): bool
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return true;
        }
        if ($this->user) {
            activity('ورود ناموفق')->causedByAnonymous()->event('loginFailed')->performedOn($this->user)->withProperties(['ip_address', request()->ip()])->log('تلاش ناموفق بیش از حد مجاز در ورود به سایت');
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        $this->addError('username', trans('auth.throttle', [
            'seconds' => $seconds,
            'minutes' => ceil($seconds / 60),
        ]));
        return false;
    }


    /** login and generate session for the user
     * @param User $user
     */
    protected function generateSessionAndLogin(User $user)
    {
        \auth()->loginUsingId($this->user->id);
        $this->authenticated();
        RateLimiter::clear($this->throttleKey());
        request()->session()->regenerate();
        session()->forget('intendedPath');
        $this->user->setData('telegram-ad-show', "not-showed");
        $this->redirect($this->redirectPath);
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    protected function throttleKey(): string
    {
        return Str::lower($this->username) . '|' . request()->ip();
    }

    /**check user credentials
     * @param User|null $user
     * @return bool
     */
    protected function checkCredentials(User|null $user): bool
    {
        if ($this->user && Hash::check($this->password, $this->user->password)) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * @throws ValidationException
     * @throws IncompatibleWithGoogleAuthenticatorException
     * @throws InvalidCharactersException
     * @throws SecretKeyTooShortException
     */
    public function verify2fa()
    {
        try {
            $this->validateOnly('google2FA_code', $this->rules);
            if (!$this->isNotRateLimited())
                return;
            if ($this->google2FA_code == '') {
                $this->addError('google2FA_code', 'کد احراز هویت دوعاملی الزامی است');
                return;
//                throw ValidationException::withMessages(['کد احراز هویت دوعاملی الزامی است']);
            }
            if (strlen($this->google2FA_code) < 6) {
                $this->addError('google2FA_code', 'کد احراز هویت دوعاملی حداقل شامل 6 رقم است');
                return;
//                throw ValidationException::withMessages(['کد احراز هویت دوعاملی حداقل شامل 6 رقم است']);
            }
            $google2FA = new Google2FA();
            if ($this->user && !$google2FA->verify($this->google2FA_code, $this->user->getData('2fa_secret'))) {
                RateLimiter::hit($this->throttleKey());
                $this->addError('google2FA_code', __('auth.2fa_failed'));
                return;
//                throw ValidationException::withMessages([__('auth.2fa_failed')]);
            } else {
                RateLimiter::clear($this->throttleKey());
                $this->generateSessionAndLogin($this->user);
            }
        } catch (ValidationException $validationException) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => $validationException->getMessage()]);
        } catch (\Exception|\Throwable $exception) {
            Log::critical($exception);
            $this->dispatchBrowserEvent('alert', ['type' => 'info', 'message' => 'متاسفانه در ورود به پنل کاربری خطایی پیش آمده است، ضمن عذرخواهی از مشکل پیش آمده، از صبر و شکیبایی شما تا رفع آن متشکریم', 'timeOut' => '8000']);
        }
    }

    /**
     * check and validate recovery code, then generate 2fa_disabled session, reset 2fa and redirect to home
     * @throws ValidationException
     */
    public function checkRecoveryCode()
    {
        try {
            $this->validateOnly('recovery_code', $this->rules);
            if (!$this->isNotRateLimited())
                return;

            if ($this->recovery_code == '') {
                RateLimiter::hit($this->throttleKey());
                $this->addError('recovery_code', 'فیلد کد پشتیبان الزامی است');
                return;
//                throw ValidationException::withMessages([__('فیلد کد پشتیبان الزامی است')]);
            }
            if ($this->user && $this->user->getData('recovery_codes') && !in_array($this->recovery_code, json_decode($this->user->getData('recovery_codes'), true))) {
                RateLimiter::hit($this->throttleKey());
                $this->addError('recovery_code', __('auth.recovery_code_failed'));
                return;
//                throw ValidationException::withMessages([__('auth.recovery_code_failed')]);
            } else {
                RateLimiter::clear($this->throttleKey());
                $this->disableTwoFA();
                $this->generateSessionAndLogin($this->user);
            }
        } catch (ValidationException $validationException) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => $validationException->getMessage()]);
        } catch (\Exception|\Throwable $exception) {
            Log::critical($exception);
            $this->dispatchBrowserEvent('alert', ['type' => 'info', 'message' => 'متاسفانه در ورود به پنل کاربری خطایی پیش آمده است، ضمن عذرخواهی از مشکل پیش آمده، از صبر و شکیبایی شما تا رفع آن متشکریم', 'timeOut' => '8000']);
        }
    }

    /**
     * Go to Recovery Mode , where user can enter 2fa recovery codes
     */
    public function recoveryMode()
    {
        $this->recovery_mode = true;
    }

    /**
     *Do something when the user authenticated
     */
    protected function authenticated()
    {
        $this->user->setData('last_login', now());
        activity('ورود به حساب')->event('login')->causedBy($this->user)->withProperties(['ip_address', request()->ip()])->log('ورود به سایت');
    }

    public function render()
    {
        return view('livewire.authentication.login')->layout('auth.layout');
    }

    /**
     * generate 2fa_disabled session, reset 2fa
     */
    public function disableTwoFA(): void
    {
        $this->user->setData('2fa_enabled', 0);
        $this->user->setData('2fa_secret');
        $this->user->setData('recovery_codes');
        session()->flash('2fa_disabled', true);
    }
}
