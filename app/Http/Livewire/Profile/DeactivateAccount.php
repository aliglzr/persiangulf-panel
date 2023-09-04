<?php

namespace App\Http\Livewire\Profile;

use App\Models\Server;
use App\Models\User;
use Livewire\Component;

class DeactivateAccount extends Component {
    public User $user;
    public string $reason = '';

    public function mount(User $user) {
        $this->user = $user;
    }

    public function rules() {
        return [
            'reason' => [$this->user->active ? 'required' : 'nullable', 'string', 'min:3'],
        ];
    }

    public function attributes() {
        return [
            'reason' => 'دلیل'
        ];
    }

    public function messages() {
        return [
            'reason.required' => ['دلیل غیر فعال سازی الزامی است']
        ];
    }

    public function updated($field) {
        $this->validateOnly($field, $this->rules(), $this->messages(), $this->attributes());
    }

    public function toggleActivation() {
        $this->validate($this->rules(), $this->messages(), $this->attributes());
        $this->user->disableLogging();
        if (!$this->user->active) {
            // Activated user
            $this->user->active = true;
            if ($this->user->isClient()) {
                $this->user->activeConnections();
            }
            activity('فعال سازی حساب')->causedBy(auth()->user())->performedOn($this->user)->withProperties(['ip_address', request()->ip()])->event('فعال سازی حساب')->log('');
        } else {
            // Deactivated user
            $this->user->active = false;
            if ($this->user->isClient()) {
                $this->user->deactivateConnections();
            }
            $this->user->setData('deactivation_reason', $this->reason);
            activity('مسدود سازی حساب')->causedBy(auth()->user())->performedOn($this->user)->withProperties(['ip_address', request()->ip()])->event('مسدود سازی حساب')->log($this->reason);
            $this->dispatchBrowserEvent('closeModal');
        }
        $this->user->save();
        $this->user->enableLogging();
    }

    public function render() {
        return view('livewire.profile.deactivate-account');
    }
}
