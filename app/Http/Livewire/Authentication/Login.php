<?php

namespace App\Http\Livewire\Authentication;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Livewire\Component;

/**
 * @property null $user
 */
class Login extends Component
{


    public string $username = '';
    public string $password = '';
    public User|null $user = null;
    public string $redirectPath = '/dashboard'; // the path that user should redirectTo after successful login


    protected array $rules = [
        'username' => ['required', 'string'],
        'password' => ['required', 'min:6'],
    ];

    /**
     * handle login logic
     */
    public function login(): void
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

        $this->generateSessionAndLogin($this->user);
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
    protected function generateSessionAndLogin(User $user): void
    {
        auth()->loginUsingId($this->user->id);
        $this->authenticated();
        RateLimiter::clear($this->throttleKey());
        request()->session()->regenerate();
        session()->forget('intendedPath');
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
     *Do something when the user authenticated
     */
    protected function authenticated(): void
    {
        $this->user->setData('last_login', now());
    }

    public function render()
    {
        return view('livewire.authentication.login')->layout('auth.layout');
    }
}
