<?php

namespace App\Http\Livewire\Bot;

use App\Models\Option;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Options extends Component
{
    public string $bot_token = '';
    public ?string $bot_username = '';
    public bool $force_join = false;
    public string $force_join_message = '';
    public string $start_message = '';
    public array $force_join_channels = [];
    public function mount(): void
    {
        $this->bot_token = Option::get('sales_bot_token') ?? '';
        $this->bot_username = Option::get('sales_bot_username') ?? '';
        $this->force_join = Option::get('sales_bot_force_join') ?? false;
        $this->start_message = Option::get('sales_bot_start_message') ?? '';
        $this->force_join_channels = json_decode(Option::get('sales_bot_force_join_channels'), true) ?? [];
        $this->force_join_message = Option::get('sales_bot_force_join_message') ?? '';
    }

    public function rules(): array
    {
        return [
            'bot_token' => ['nullable', 'string'],
            'bot_username' => ['nullable', 'string'],
            'start_message' => ['nullable', 'string'],
            'force_join_channels' => ['nullable', 'array'],
            'force_join' => ['boolean', 'required'],
            'force_join_message' => ['string', 'nullable'],
        ];
    }

    public function addForceJoinChannel(): void
    {
        $this->force_join_channels[] = [
            'name' => '',
            'id'   => '',
            'join_link' => '',
        ];
    }

    public function deleteForceJoinChannelItem($itemKey): void
    {
        array_splice($this->force_join_channels, $itemKey, 1);
    }

    public function updated($field): void
    {
        $this->validateOnly($field, $this->rules());
    }

    public function save(): void
    {
        $this->validate($this->rules());
        Option::set('sales_bot_token', $this->bot_token);
        Option::set('sales_bot_username', $this->bot_username);
        Option::set('sales_bot_force_join', $this->force_join);
        Option::set('sales_bot_start_message', $this->start_message);
        Option::set('sales_bot_force_join_channels', json_encode($this->force_join_channels, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE));
        Option::set('sales_bot_force_join_message', $this->force_join_message);
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'تنظیمات ربات ذخیره شد']);
    }

    /**
     * @return Application|Factory|\View
     */
    public function render(): mixed
    {
        return view('livewire.bot.options');
    }
}
