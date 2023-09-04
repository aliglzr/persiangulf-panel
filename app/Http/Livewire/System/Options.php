<?php

namespace App\Http\Livewire\System;

use App\Models\Option;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Options extends Component
{
    public string $APP_URL = '';
    public ?string $application_maintenance_message = '';
    public bool $application_maintenance_mode = false;
    public $android_application_minimum_version = 0;
    public $android_application_current_version = 0;

    public bool $buy_plans_status = false;
    public bool $clients_must_verify_email = false;
    public bool $register_agents_status = false;
    public $server_login_rate_limit = 600;
    public bool $agent_profit_status = true;
    public bool $register_clients_status = true;
    public bool $payment_status = true;
    public bool $buy_subscription_in_reserved = true;
    public $minimum_payment = 10000;
    public $inviter_profit_percent = 0;
    public $invited_profit_percent = 0;


    public function mount(): void
    {
        $this->inviter_profit_percent = Option::get('inviter_profit_percent') ?? 0;
        $this->invited_profit_percent = Option::get('invited_profit_percent') ?? 0;
        $this->buy_plans_status = Option::get('buy_plans_status') ?? true;
        $this->register_agents_status = Option::get('register_agents_status') ?? true;
        $this->server_login_rate_limit = Option::get('server_login_rate_limit') ?? 600;
        $this->APP_URL = Option::get('APP_URL') ?? false;
        $this->register_clients_status = Option::get('register_clients_status') ?? true;
        $this->agent_profit_status = Option::get('agent_profit_status') ?? true;
        $this->buy_subscription_in_reserved = Option::get('buy_subscription_in_reserved') ?? true;
        $this->application_maintenance_mode = Option::get('application_maintenance_mode') ?? false;
        $this->payment_status = Option::get('payment_status') ?? true;
        $this->clients_must_verify_email = Option::get('clients_must_verify_email') ?? false;
        $this->android_application_minimum_version = Option::get('android_application_minimum_version') ?? 0;
        $this->android_application_current_version = Option::get('android_application_minimum_version') ?? 0;
        $this->application_maintenance_message = Option::get('application_maintenance_message') ?? '';
        $this->minimum_payment = Option::get('minimum_payment') ?? 10000;
    }

    public function rules(): array
    {
        return [
            'APP_URL' => ['nullable', 'string'],
            'buy_plans_status' => ['boolean', 'required'],
            'agent_profit_status' => ['boolean', 'required'],
            'register_agents_status' => ['boolean', 'required'],
            'application_maintenance_mode' => ['boolean', 'required'],
            'register_clients_status' => ['boolean', 'required'],
            'buy_subscription_in_reserved' => ['boolean', 'required'],
            'server_login_rate_limit' => ['numeric', 'nullable'],
            'android_application_minimum_version' => ['numeric', 'nullable'],
            'android_application_current_version' => ['numeric', 'nullable'],
            'application_maintenance_message' => ['string', 'nullable'],
            'minimum_payment' => ['numeric', 'required'],
            'payment_status' => ['boolean', 'required'],
            'inviter_profit_percent' => ['numeric', 'nullable','max:100','min:0'],
            'invited_profit_percent' => ['numeric', 'nullable','max:100','min:0'],
        ];
    }

    public function updated($field): void
    {
        $this->validateOnly($field, $this->rules());
    }

    public function save(): void
    {
        $this->validate($this->rules());
        Option::set('buy_plans_status', $this->buy_plans_status);
        Option::set('clients_must_verify_email', $this->clients_must_verify_email);
        Option::set('register_agents_status', $this->register_agents_status);
        Option::set('server_login_rate_limit', $this->server_login_rate_limit);
        Option::set('minimum_payment', $this->minimum_payment);
        Option::set('APP_URL', $this->APP_URL);
        Option::set('register_clients_status', $this->register_clients_status);
        Option::set('agent_profit_status', $this->agent_profit_status);
        Option::set('payment_status', $this->payment_status);
        Option::set('buy_subscription_in_reserved', $this->buy_subscription_in_reserved);
        Option::set('application_maintenance_mode', $this->application_maintenance_mode);
        $this->android_application_minimum_version = $this->android_application_minimum_version == "" ? 0 : $this->android_application_minimum_version;
        $this->android_application_current_version = $this->android_application_current_version == "" ? 0 : $this->android_application_current_version;
        Option::set('inviter_profit_percent', $this->inviter_profit_percent);
        Option::set('invited_profit_percent', $this->invited_profit_percent);
        Option::set('android_application_minimum_version', $this->android_application_minimum_version);
        Option::set('android_application_current_version', $this->android_application_current_version);
        $this->application_maintenance_message = $this->application_maintenance_message == "" ? null : $this->application_maintenance_message;
        Option::set('application_maintenance_message', $this->application_maintenance_message);

        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'تنظیمات ذخیره شد']);
    }

    public function render()
    {
        return view('livewire.system.options');
    }
}
