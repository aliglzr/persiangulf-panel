<?php

namespace App\Http\Livewire\Authentication;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class SendEmailVerificationNotification extends Component
{
    public User $user;

    public function mount()
    {
        $this->user = auth()->user();
    }


    /**
     * send email verification notification to user , rate limited
     */
    public function send()
    {
        if (RateLimiter::tooManyAttempts('resend-email-notification-:' . $this->user->id,(auth()->user()->isManager() || auth()->user()->isSupport()) ? 100 : 2)){
            $seconds = RateLimiter::availableIn('resend-email-notification-:' . $this->user->id);
            $seconds = Carbon::now()->addSeconds($seconds)->diffForHumans();
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => "تعداد دفعات درخواست شما بیش از حد مجاز است، لطفا پس از $seconds ، مجددا امتحان کنید"]);
            return;
        }
        // if user verify the email in another tab, we alert the user that you verified your email
        if (auth()->user()->hasVerifiedEmail()) {
            $this->dispatchBrowserEvent('alert', ['type' => 'info', 'message' => 'ایمیل شما تایید شده است']);
        } else {
            auth()->user()->sendEmailVerificationNotification();
            RateLimiter::hit('resend-email-notification-:' . $this->user->id,600);
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'ایمیل حاوی لینک تایید، به آدرس ایمیل شما ارسال شد، لطفا ایمیلتان را چک کنید','timeOut' => 5000]);
        }
    }

    public function render()
    {
        return view('livewire.authentication.send-email-verification-notification');
    }
}
