<?php

namespace App\Http\Livewire\Profile\Client\Overview;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class ChangeConnectionId extends Component
{
    public User $user;
    public string $old_uuid = '';
    public function mount(User $user)
    {
        $this->user = $user;
        $this->old_uuid = $user->uuid;
    }

    public function changeConnectionId()
    {
        $rateLimiterKey = "change-connection-id-" . $this->user->id;
        if (RateLimiter::tooManyAttempts($rateLimiterKey, auth()->user()->isManager() || auth()->user()->isSupport() ? 1000 : 1)) {
            $seconds = RateLimiter::availableIn($rateLimiterKey);
            $this->dispatchBrowserEvent('toggleChangeConnectionIdModal');
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => "شما تنها مجاز به ارسال یکبار درخواست غیر فعال کردن کانکشن های قبلی طی هفته اخیر هستید"]);
            return;
        }
        try {
            DB::transaction(function () use ($rateLimiterKey) {
                $new_uuid = \Str::uuid();
                $this->user->resetUUID($new_uuid);
                activity('تغییر شناسه کانکشن')->causedBy(auth()->user())->event('changeConnectionId')->performedOn($this->user)->withProperties(['ip_address', request()->ip(),'old_uuid' => $this->old_uuid,'new_uuid' => $new_uuid])->log('تغییر شناسه کانکشن');
                $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'تغییر شناسه با موفقیت انجام شد، جهت اتصال به سرویس مجددا کانکشن دریافت کنید']);
                RateLimiter::hit($rateLimiterKey, 86400 * 7);
            });
        } catch (\Exception | \Throwable $exception) {
            Log::critical($exception);
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'خطا در تغییر شناسه، لطفا بعدا تلاش کنید']);
        }
    }

    public function render()
    {
        return view('livewire.profile.client.overview.change-connection-id');
    }
}
