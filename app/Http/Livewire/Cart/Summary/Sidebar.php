<?php

namespace App\Http\Livewire\Cart\Summary;

use App\Models\Cart;
use App\Models\Discount;
use App\Models\Invoice;
use App\Models\Option;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\InvoicesNotifications\InvoicePaidNotification;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Sidebar extends Component
{
    public ?Discount $discount = null;
    public Transaction $transaction;

    public Collection $carts;
    public User $user;
    public string $code = '';
    public int $totalPrice = 0;
    public int $discountPrice = 0;
    public int $finalPrice = 0;
    public int $discountPercent = 0;
    public bool $paid = false;

    public function mount()
    {
        $this->user = auth()->user();
        $this->carts = Cart::where('user_id', $this->user->id)->get();
        $this->calculatePrices();
        $this->discount = null;
        $this->transaction ??= new Transaction();
    }


    public function rules()
    {
        return [
            'code' => ['required', 'string']
        ];
    }

    protected $listeners = [
        'updateCart' => 'updateSidebar'
    ];

    public function updateSidebar(){
        $this->carts = Cart::where('user_id', $this->user->id)->get();
        if (!is_null($this->discount?->plan_id) && !in_array($this->discount?->plan_id, $this->carts->pluck('plan_id')->toArray())) {
            $this->discount = null;
            $this->code = '';
        }
        $this->calculatePrices();
    }

    public function validateDiscountCode()
    {
        if ($this->discount){
           $this->discount = null;
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'کد تخفیف حذف شد']);
            $this->calculatePrices();
            $this->code = '';
            return;
        }
        if ($this->code == '') {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'کد تخفیف وارد نشده است']);
            return;
        }
        /* @var Discount $discount */
        $discount = Discount::where('code', $this->code)->first();
        if (is_null($discount)) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'کد تخفیف معتبر نیست']);
            return;
        }
        if (!$discount->active) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'کد تخفیف معتبر نیست']);
            return;
        }
        if (!is_null($discount->expires_at) && $discount->expires_at < now()) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'مدت زمان اعتبار کد تخفیف به اتمام رسیده است']);
            return;
        } else if (!is_null($discount->remaining_count) && $discount->remaining_count === 0) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'کد تخفیف معتبر نیست']);
            return;
        } else if (!is_null($discount->user_id) && $discount->user_id !== $this->user->id) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'کد تخفیف معتبر نیست']);
            return;
        } else if (!is_null($discount->plan_id) && !in_array($discount->plan_id, $this->carts->pluck('plan_id')->toArray())) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'کد تخفیف متعلق به طرح دیگری است']);
            return;
        }
        $this->discount = $discount;
        $this->calculatePrices();
        $this->dispatchBrowserEvent('alert',['type' => 'success', 'message' => "کد تخفیف {$discount->code} اعمال شد. "]);
    }

    public function pay()
    {
        if ($this->paid){
            return ;
        }
        $this->carts = $this->user->cart()->get();
        /** @var Cart $cart */
        foreach ($this->carts as $cart){
            if ($cart->plan->inventory == 0){
                $cart->delete();
            }
        }
        $this->carts = $this->user->cart()->get();
        if ($this->carts->count() == 0){
            $this->dispatchBrowserEvent('alert',['type' => 'info', 'message' => 'سبد خرید شما خالی میباشد','redirect' => route('plans.buy')]);
            return ;
        }
        foreach ($this->carts as $cart){
            if (!$this->user->isUserAllowedToBuy($cart->plan)){
                $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => 'در حال حاضر طرح فعالی با این محدودیت زمانی دارید']);
                return ;
            }
        }
        if (Option::get('buy_plans_status') != 1){
            $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => 'با عرض پوزش فروش به صورت موقت غیر فعال است، لطفا بعدا مراجعه کنید']);
            return ;
        }
        $balance = $this->user->balance;
        if ($balance >= $this->finalPrice) {
            $this->createTransaction();
            $this->decreaseBalance();
            $invoice = $this->createInvoice();
            if ($invoice->user->hasVerifiedEmail()){
                $invoice->user->notify(new InvoicePaidNotification($invoice));
            }
            $this->emptyCart();
            $this->reduceDiscountNumber();
            $this->paid = true;
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'پرداخت با موفقیت انجام شد', 'redirect' => route('invoices.show',$invoice)]);
        }else{
            $deficiencyAmount = convertNumbers(number_format($this->finalPrice - $balance));
            $this->dispatchBrowserEvent('not-enough-balance', [ 'message' => "لطفاً جهت خرید طرح ابتدا اعتبار خود را به مبلغ $deficiencyAmount تومان افزایش دهید!"]);
        }
    }

    public function increaseBalance() {
        $deficiencyAmount = $this->finalPrice - $this->user->balance;
        $this->emitTo('layout.modals.wallet-balance.wallet-balance-modal', 'increase-wallet-balance', $deficiencyAmount);
    }

    public function createTransaction()
    {
        $this->transaction = Transaction::create([
            'amount' => -$this->finalPrice,
            'user_id' => $this->user->id,
            'balance_before_transaction' => $this->user->balance,
            'balance_after_transaction' => $this->user->balance - $this->finalPrice,
            'status' => 'paid',
        ]);
    }

    public function decreaseBalance()
    {
        $this->user->decrement('balance', $this->finalPrice);
    }

    public function render()
    {
        return view('livewire.cart.summary.sidebar');
    }

    public function createInvoice()
    {
        /* @var Invoice $invoice */
        $invoice = $this->transaction->invoice()->create([
            'user_id' => $this->user->id,
            'discount_id' => $this->discount?->plan_id == null ? $this->discount?->id : null,
            'total_amount' => $this->totalPrice,
            'total_discount' => $this->discountPrice,
            'net_amount_payable' => $this->finalPrice
        ]);

        $this->carts->each(function (Cart $cart) use ($invoice) {
            //create planUsers
            $discount_price = $this->discount?->plan?->id == $cart->plan->id ? $this->discountPrice : 0;
            $this->user->plans()->attach($cart->plan->id,[
                'remaining_user_count' => $cart->plan->users_count,
                'invoice_id' => $invoice->id,
                'plan_title' => $cart->plan->title,
                'plan_price' => $cart->plan->price,
                'plan_sell_price' => $cart->plan->sell_price,
                'plan_duration' => $cart->plan->duration,
                'plan_users_count' => $cart->plan->users_count,
                'plan_traffic' => $cart->plan->traffic,
                'only_bot' => $cart->plan->only_bot,
                'discount_id' => $this->discount?->id,
                'discount_price' => $discount_price,
                'discount_percent' => $this->discount?->percent ?? 0,
                'price_after_discount' =>$cart->plan->price - $discount_price
            ]);
            $cart->plan->decrement('inventory');
        });

        return $invoice;
    }

    public function emptyCart()
    {
        $this->user->cart()->each(function (Cart $cart){
           $cart->delete();
        });
    }

    public function reduceDiscountNumber()
    {
        if ($this->discount?->remaining_count){
            $this->discount->decrement('remaining_count');
        }
    }

    public function calculatePrices(): void
    {
        $this->totalPrice = 0;
        $this->discountPrice = 0;
        $this->discountPercent = 0;
        /* @var Collection $carts */
        foreach ($this->carts as $cart) {
            $this->totalPrice += $cart->plan->price;
        }
        if (!is_null($this->discount)){
            if (is_null($this->discount->plan_id)) {
                $this->discountPrice = $this->totalPrice * ($this->discount->percent/100);
            } else {
                $this->discountPrice = $this->discount->plan?->price * ($this->discount->percent/100);
            }
            if ($this->discount->max) {
                $this->discountPrice = min([$this->discountPrice,$this->discount->max]);
            }
        }
        $this->finalPrice = $this->totalPrice - $this->discountPrice;
    }
}
