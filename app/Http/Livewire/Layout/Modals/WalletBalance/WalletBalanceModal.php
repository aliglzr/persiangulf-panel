<?php

namespace App\Http\Livewire\Layout\Modals\WalletBalance;

use App\Models\Option;
use App\Models\User;
use Livewire\Component;
use Shetabit\Multipay\Abstracts\Driver;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;

class WalletBalanceModal extends Component
{
    protected $listeners = ['increase-wallet-balance' => 'increase'];
    public $amount = '';


    /**
     * This function may be used in cart for increasing Deficiency amount of the product
     */
    public function increase($amount = null){
        if($amount) {
            $this->amount = $amount;
        }
        if (empty(Option::get('payment_status'))){
            $this->dispatchBrowserEvent('alert',['type' => 'error','message' => 'با عرض پوزش، امکان افزایش اعتبار موقتا غیر فعال است.']);
            return;
        }
        $this->amount = preg_replace('/[^0-9.]/', '', $this->amount);
        $minimum_payment = Option::get('minimum_payment') ?? 10000;
        if($this->amount < $minimum_payment) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => "⚠️ حداقل مبلغ جهت افزایش موجودی، ".convertNumbers(number_format($minimum_payment))." تومان می باشد."]);
            return;
        }
        $invoice = new Invoice();

// Set invoice amount.
        try {
            $invoice->amount($this->amount);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('alert',['type' => 'error','message' => 'خطا در ارتباط با درگاه، لطفا دوباره امتحان کنید']);
            return;
        }

        $showAmount = convertNumbers(number_format($amount));
        $invoice->detail(['increaseBalance' => "افزایش اعتبار از طریق ربات به مبلغ $showAmount تومان "]);

        app('url')->forceRootUrl("https://" . (Option::get('APP_URL')) . "/");
        try {
            $this->redirect(json_decode(Payment::callbackUrl(route('pay.callback'))->purchase($invoice, function (Driver $driver, $transactionId) {
                $payment = new \App\Models\Payment();
                $payment->amount = $this->amount;
                $payment->gateway_transaction_id = $transactionId;
                $payment->gateway_driver = get_class($driver);
                $payment->status = 'pending';
                $payment->user_id = auth()->user()->id;
                $payment->data = [];
                $payment->save();
            })->pay()->toJson())->action);
            app('url')->forceRootUrl("https://" . request()->httpHost() . "/");
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('alert',['type' => 'error','message' => 'خطا در ارتباط با درگاه، لطفا دوباره امتحان کنید']);
        }
    }

    public function updatedAmount($value){
        $value = preg_replace('/[^0-9.]/', '', $value);
        $this->amount = number_format(floatval($value));
    }

    public function render()
    {
        return view('livewire.layout.modals.wallet-balance.wallet-balance-modal');
    }
}
