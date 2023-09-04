<?php

namespace App\Http\Livewire\Profile;

use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Component;

class EmailPreferences extends Component {
    public User $user;
    private array $options = [
        'ticket_email_notification', 'discount_email_notification', 'invoice_email_notification', 'payment_email_notification', 'subscription_email_notification'
    ];

    public array $email_preferences = [];

    public bool $email_subscription = false;

    public function mount(User $user) {
        $this->user = $user;
        $this->email_preferences = $this->user->getData('email_preferences') ? json_decode($this->user->getData('email_preferences'), true) : [];
        if ($user->getData('email_subscription') && $user->email_verified_at) {
            $this->email_subscription = true;
        }
        $this->init();
    }

    public function resetPreferences() {
        $this->user->setData('email_preferences');
        $this->email_preferences = [];
        $this->dispatchBrowserEvent('alert', ['type' => 'info', 'message' => 'تنظیمات ایمیل ریست شد']);
    }

    private function setEmailPreferences(array $preferences){
        $this->email_preferences = $preferences;
        $this->user->setData('email_preferences',json_encode($preferences));
    }

    public function updatedEmailSubscription($value) {
        if ($this->user->email_verified_at) {
            $this->user->setData('email_subscription', $value);
            if ($value){
                $this->setEmailPreferences([]);
            }
        } else {
            $this->email_subscription = false;
            $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => $this->user->email ? 'لطفا ابتدا ایمیل خود را تایید کنید' : 'ایمیلی برای شما ثبت نشده است']);
        }
    }

    public function toggleEmailPreferencesValue(string $value,bool $checked) {
        if (in_array($value, $this->options)) {
            $this->email_preferences = $this->user->getData('email_preferences') ? json_decode($this->user->getData('email_preferences'), true) : [];
            if ($checked) {
                if (($key = array_search($value, $this->email_preferences)) !== false) {
                    unset($this->email_preferences[$key]);
                }
            } else {
                if (!($key = array_search($value, $this->email_preferences))) {
                    $this->email_preferences[] = $value;
                }
            }
            $this->setEmailPreferences($this->email_preferences);
            $this->init();
        }
    }

    public function init() {
        if (count($this->email_preferences) == count($this->options)){
            $this->email_subscription = false;
            $this->user->setData('email_subscription',false);
        }
    }

    public function isChecked($value) {
        if (!in_array($value, $this->user->getData('email_preferences') ? json_decode($this->user->getData('email_preferences'), true) : [])) {
            return 'checked';
        }
        return '';
    }

    public function render() {
        return view('livewire.profile.email-preferences');
    }
}
