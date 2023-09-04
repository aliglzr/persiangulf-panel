<?php

namespace App\Http\Livewire\System\Options;

use App\Models\Option;
use Livewire\Component;

class ReferralProfits extends Component
{
    public array $profits = [];

    public function mount()
    {
        $this->profits = !empty(Option::get('agents_profit_percent')) ? json_decode(Option::get('agents_profit_percent'),true) : [];
    }

    public function add() {
        $this->profits[] = [
            'percent' => 0,
        ];
    }

    public function del($key) {
        array_splice($this->profits, $key, 1);
    }

    public function save() {
        $this->validateProfits();
        Option::set('agents_profit_percent', json_encode($this->profits));
        activity('تغییر سود نمایندگان')->causedBy(auth()->user())->event('changeAgentProfit')->withProperties(['profits' => json_encode($this->profits)])->log('تغییر سود نمایندگان');
        $this->dispatchBrowserEvent('alert',['type' => 'success','message'=>'سود نمایندگان با موفقیت بروز رسانی شد']);
    }

    public function validateProfits()
    {
        $this->validate([
            'profits.*.percent' => 'required|numeric|max:100',
        ],[
            'profits.percent.numeric' => 'درصد سود باید عددی باشد.',
        ],[
            'profits.*.percent' => 'درصد سود',
        ]);
    }

    public function render()
    {
        return view('livewire.system.options.referral-profits');
    }
}
