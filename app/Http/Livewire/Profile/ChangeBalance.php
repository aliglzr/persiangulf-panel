<?php

namespace App\Http\Livewire\Profile;

use App\Models\Payment;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\BalanceNotifications\IncreaseBalanceNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ChangeBalance extends Component
{
    public User $user;
    public bool $isLoading = false;
    public string $mode = 'increase';
    public array $modes = ['increase','decrease'];
    public string $description = '';
    public $amount = '';

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function rules()
    {
        return [
            'description' => ['required', 'string', 'min:3'],
            'amount' => ['required','min:1'],
            'mode' => ['string','required',Rule::in($this->modes)]
        ];
    }

    public function attributes()
    {
        return [
            'description' => 'توضیحات',
            'amount' => 'مبلغ'
        ];
    }

    public function messages()
    {
        return [
            'description.required' => ['دلیل افزایش اعتبار الزامی است'],
            'amount.required' => ['فیلد مبلغ الزامی است'],
        ];
    }

    public function updated($field)
    {
        $this->validateOnly($field, $this->rules(), $this->messages(), $this->attributes());
    }

    public function updatedAmount($value){
        $value = preg_replace('/[^0-9.]/', '', $value);
        $this->amount = number_format(floatval($value));
    }


    public function change(){
        if ($this->isLoading){
            return;
        }
        $this->isLoading = true;
        if (!auth()->user()->isManager()){
            $this->dispatchBrowserEvent('alert',['type' => 'error','message' => 'عدم دسترسی']);
            return;
        }
        $this->amount = preg_replace('/[^0-9.]/', '', $this->amount);
        $this->validate($this->rules(), $this->messages(), $this->attributes());
            try {
                /** @var Transaction $transaction */
                $transaction = $this->user->transactions()->create([
                    'amount' => $this->mode == 'increase' ? $this->amount : -$this->amount,
                    'data' => json_encode(['message' => $this->description]),
                    'balance_before_transaction' => $this->user->balance,
                    'balance_after_transaction' => $this->user->balance + ($this->mode == 'increase' ? $this->amount : -$this->amount),
                ]);
                if ($this->mode == 'increase'){
                    /** @var Payment $payment */
                    $payment = $this->user->payments()->create([
                        'transaction_id' => $transaction->id,
                        'amount' => $this->amount,
                        'data' => array(),
                        'gateway_transaction_id' => 1,
                        'gateway_driver' => '',
                        'reference_id' => 1,
                        'status' => 'paid'
                    ]);
                    $this->user->increment('balance',intval($this->amount));
                    activity("افزایش اعتبار")->by(auth()->user())->on($this->user)->event("افزایش اعتبار")->withProperties(['description' => $this->description,'amount' => convertNumbers(number_format($this->amount)),'transaction' => $transaction->toArray(),'payment' => $payment->toArray()])->log("افزایش اعتبار".$this->user->username);
                    if ($this->user->hasVerifiedEmail()){
                        $this->user->notify(new IncreaseBalanceNotification($transaction));
                    }
                    $this->dispatchBrowserEvent('alert',['type' => 'success','message' => 'موجودی کاربر با موفقیت افزایش یافت']);
                } else if ($this->mode == 'decrease'){
                    $this->user->decrement('balance',intval($this->amount));
                    activity("کاهش اعتبار")->by(auth()->user())->on($this->user)->event("کاهش اعتبار")->withProperties(['description' => $this->description,'amount' => convertNumbers(number_format(-$this->amount)),'transaction' => $transaction->toArray()])->log("کاهش اعتبار".$this->user->username);
                    $this->dispatchBrowserEvent('alert',['type' => 'success','message' => 'موجودی کاربر با موفقیت کاهش یافت']);
                }else{
                    $this->dispatchBrowserEvent('error' , ['type' => 'error','message' => 'عملیات نامعتبر']);
                    return;
                }
                $this->isLoading = false;
                $this->dispatchBrowserEvent('refreshTables');
                $this->dispatchBrowserEvent('closeModal');
            }catch (\Exception | \Throwable $exception){
                $this->isLoading = false;
                \Log::critical($exception);
                $this->dispatchBrowserEvent('alert',['type' => 'error','message' => 'خطا در تغییر اعتبار']);
            }
    }

    public function resetModal(){
        $this->amount = 0;
        $this->description = '';
        $this->isLoading = false;
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.profile.change-balance');
    }
}
