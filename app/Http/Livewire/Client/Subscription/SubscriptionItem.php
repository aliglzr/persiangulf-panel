<?php

namespace App\Http\Livewire\Client\Subscription;

use App\Core\Extensions\Telegram\Bot\Api;
use App\Models\Invoice;
use App\Models\Option;
use App\Models\PlanUser;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\InvoicesNotifications\InvoicePaidNotification;
use App\Notifications\SubscriptionNotifications\ReservedSubscriptionNotification;
use App\Notifications\SubscriptionNotifications\StartSubscriptionNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Telegram\Bot\Exceptions\TelegramSDKException;

class SubscriptionItem extends Component
{
    public PlanUser $planUser;
    public User $user;
    public ?User $solidSale;
    public Transaction $transaction;
    public bool $paid = false;
    public float $subscriptionPrice = 0.0;
    public float $sharePrice = 0.0;

    protected function getListeners()
    {
        return [
            "buySubscription" . $this->planUser->id => 'buySubscription',
        ];
    }

    public function mount(PlanUser $planUser)
    {
        $this->solidSale = User::where('username', 'solidvpn_sales')->first();
        if (is_null($this->solidSale)) {
            abort(404);
        }
        $this->user = auth()->user();
        $this->planUser = $planUser;
        $planUserPrice = $this->planUser->plan_price / $this->planUser->plan_users_count;
        $this->subscriptionPrice = $this->planUser->plan_sell_price;
        $this->sharePrice = intval($this->planUser->plan_sell_price * 0.2);
        $this->transaction ??= new Transaction();
    }

    /**
     * @throws TelegramSDKException
     */
    public function buySubscription($isFromBot = false, $user = null, $planUser = null): int
    {
        if ($isFromBot) {
            $this->user = $user;
            $this->planUser = $planUser;
            $this->solidSale = User::where('username', 'solidvpn_sales')->first();
            $planUserPrice = $this->planUser->plan_price / $this->planUser->plan_users_count;
            $this->subscriptionPrice = $this->planUser->plan_sell_price;
            $this->sharePrice = intval($this->planUser->plan_sell_price * 0.2);
            $this->transaction ??= new Transaction();
        } else {
            $this->user = auth()->user();
        }
        if ($this->paid) {
            return 1010;
        }
        if (!$this->user->isClient()) {
            return 1011;
        }
        if (!$this->user->hasVerifiedEmail() && (!empty(Option::get('clients_must_verify_email')))) {
            if (!$isFromBot) {
                $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => 'مشترک گرامی، لطفا جهت خرید اشتراک ابتدا ایمیل خود را تایید کنید']);
                return 1012;
            }
        }
        if (!is_null($this->user->getReservedSubscription())) {
            if (!$isFromBot) {
                $this->dispatchBrowserEvent('have-reserved-subscription');
            }
            return 1013;
        }
        if ($this->user->hasActiveSubscription() && empty(Option::get('buy_subscription_in_reserved'))) {
            if (!$isFromBot) {
                $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'امکان خرید اشتراک به طور موقت غیر فعال است.', 'timeOut' => 5000]);
            }
            return 1014;
        }
        if ($this->user->balance < $this->subscriptionPrice) {
            $deficiencyAmount = convertNumbers(number_format($this->subscriptionPrice - $this->user->balance));
            if (!$isFromBot) {
                $this->dispatchBrowserEvent('not-enough-balance', ['message' => "لطفاً جهت خرید اشتراک ابتدا اعتبار خود را به مبلغ $deficiencyAmount تومان افزایش دهید!", 'amount' => $this->subscriptionPrice - $this->user->balance]);
            }
            return 1015;
        }
        try {
            DB::transaction(function () use ($isFromBot) {
                $this->createTransaction();
                $this->decreaseBalance();
                $this->payAgentShareProfit();
                $invoice = $this->createInvoice();
                $this->payInvitationProfit();
                $this->createSubscription($invoice);
                $this->planUser->decrement('remaining_user_count');
                if ($invoice->user->hasVerifiedEmail()) {
                    $invoice->user->notify(new InvoicePaidNotification($invoice));
                }
                $this->paid = true;
                if (!$isFromBot) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'پرداخت با موفقیت انجام شد', 'redirect' => route('invoices.show', $invoice)]);
                }
            });
        } catch (\Throwable|\Exception $e) {
            Log::critical($e);
            if ($isFromBot) {
                return 1016;
            } else {
                $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'خطا در پرداخت']);
            }
        }
        return 200;
    }

    public function createTransaction()
    {
        $this->transaction = Transaction::create([
            'amount' => -$this->subscriptionPrice,
            'user_id' => $this->user->id,
            'balance_before_transaction' => $this->user->balance,
            'balance_after_transaction' => $this->user->balance - $this->subscriptionPrice,
            'status' => 'paid',
        ]);
    }

    private function decreaseBalance()
    {
        $this->user->decrement('balance', $this->subscriptionPrice);
    }

    public function payAgentShareProfit()
    {
        if (is_null($this->user->introducer)) {
            $this->user->reference_id = $this->solidSale->id;
            $this->user->save();
        }
        $username = $this->user->username;
        $this->user->introducer->transactions()->create([
            'amount' => $this->sharePrice,
            'data' => json_encode(['share' => true, 'message' => "سود خرید اشتراک کاربر با نام کاربری $username"]),
            'balance_before_transaction' => $this->user->introducer->balance,
            'balance_after_transaction' => $this->user->introducer->balance + $this->sharePrice
        ]);
        $this->user->introducer->increment('balance', $this->sharePrice);
        if ($this->user->introducer->id == $this->solidSale->id) {
            $this->solidSale->balance += $this->sharePrice;
        }
        $soldPrice = $this->planUser->plan_sell_price - $this->sharePrice;
        $this->solidSale->transactions()->create([
            'amount' => $soldPrice,
            'data' => json_encode(['share' => true, 'message' => "خرید اشتراک کاربر با نام کاربری $username"]),
            'balance_before_transaction' => $this->solidSale->balance,
            'balance_after_transaction' => $this->solidSale->balance + $soldPrice
        ]);
        $this->solidSale->increment('balance', $soldPrice);
    }

    public function createInvoice(): Model
    {
        return $this->transaction->invoice()->create([
            'user_id' => $this->user->id,
            'total_amount' => $this->subscriptionPrice,
            'net_amount_payable' => $this->subscriptionPrice
        ]);
    }

    /**
     * @throws TelegramSDKException
     */
    public function payInvitationProfit()
    {
        if ($this->user->subscriptions()->count() == 0 && $this->user->inviter && $this->user->inviter->isClient()) {

            $bot = new Api(Option::get('sales_bot_token') ?? config('services.telegram-bot-api.token'));
            $inviter_profit_percent = Option::get('inviter_profit_percent') ?? 0;
            $invited_profit_percent = Option::get('invited_profit_percent') ?? 0;
            if (!empty($inviter_profit_percent)) {
                $inviter_profit = ($this->subscriptionPrice * $inviter_profit_percent) / 100;
                /** @var Transaction $transaction */
                $transaction = $this->user->inviter->transactions()->create([
                    'amount' => $inviter_profit,
                    'data' => json_encode(['message' => "هدیه دعوت کاربر " . $this->user->full_name . ' با نام کاربری ' . $this->user->username]),
                    'balance_before_transaction' => $this->user->balance,
                    'balance_after_transaction' => $this->user->balance + $inviter_profit,
                ]);
                $amount = convertNumbers(number_format($inviter_profit)) . " تومان";
                $invitedId = convertNumbers($this->user->id);
                if ($this->user->inviter->from_bot && $this->user->inviter->tid != null) {
                    $bot->sendMessage([
                        "chat_id" => $this->user->inviter->tid,
                        "text" => "✅ یک کاربر با شناسه کاربری $invitedId اولین خرید اشتراک خود را با کدمعرف شما انجام داد. ۱۰ درصد از مبلغ خرید کاربر موردنظر به مبلغ $amount به عنوان هدیه به حساب کاربری شما و ایشان اضافه شد.

سپاس از همراهی و اعتماد شما مشتری عزیز❤️"
                    ]);
                }
                $this->user->inviter->increment('balance', $inviter_profit);
            }
            if (!empty(Option::get('invited_profit_percent'))) {
                $invited_profit = round(($this->subscriptionPrice * $invited_profit_percent) / 100);
                /** @var Transaction $transaction */
                $transaction = $this->user->transactions()->create([
                    'amount' => $invited_profit,
                    'data' => json_encode(['message' => 'هدیه دعوت']),
                    'balance_before_transaction' => $this->user->balance,
                    'balance_after_transaction' => $this->user->balance + $invited_profit,
                ]);
                $amount = convertNumbers(number_format($invited_profit)) . " تومان";
                if ($this->user->from_bot && $this->user->tid != null) {
                    $bot->sendMessage([
                        "chat_id" => $this->user->tid,
                        "text" => "✅ شما با استفاده از کد معرف دوستتان از سالید وی پی ان اشتراک خریداری کردید. ۱۰ درصد از مبلغ خرید اشتراک شما به مبلغ $amount به عنوان هدیه به حساب کاربری شما و ایشان اضافه شد.

🎁 شما نیز می‌توانید با ارسال بنر تبلیغاتی خود به دوستانتان و جذب مشتری، ۱۰ درصد از مبلغ خرید اول مشتری معرفی شده را به عنوان هدیه به حساب کاربری خود و ایشان اضافه کنید.

برای دسترسی به بنر تبلیغاتی خود روی متن زیر کلیک کنید👇🏻
/banner

📌 همچنین از طریق ورود به منوی اصلی و کلیک برروی 'پروفایل من' به منوی 'زیرمجموعه' و بنر تبلیغاتی خود دسترسی داشته باشید.

سپاس از همراهی و اعتماد شما مشتری عزیز❤️"
                    ]);
                }
                $this->user->increment('balance', $invited_profit);
            }
        }
    }

    private function createSubscription(Invoice $invoice)
    {
        $using = !$this->user->hasActiveSubscription();
        if ($using) {
            $this->user->subscriptions()->update(['using' => false]);
        }
        $newSubscription = $this->user->subscriptions()->create([
            'starts_at' => $using ? now() : null,
            'ends_at' => $using ? now()->addDays($this->planUser->plan_duration) : null,
            'total_traffic' => $this->planUser->plan_traffic,
            'duration' => $this->planUser->plan_duration,
            'plan_user_id' => $this->solidSale->plans()->where('plan_id', $this->planUser->plan_id)->first()->planUser->id,
            'invoice_id' => $invoice->id,
            'using' => $using]);
        if ($using) {
            // Here a subscription is activated for user, and it's not reserved
            $this->user->resetTrafficAndActiveConnections();
            // Notify user that a new subscription has been activated
            if ($invoice->user->hasVerifiedEmail()) {
                $this->user->notify(new StartSubscriptionNotification($newSubscription));
            }
        } else {
            // Here a subscription is reserved for user
            // Notify user that a new subscription has been reserved
            if ($invoice->user->hasVerifiedEmail()) {
                $this->user->notify(new ReservedSubscriptionNotification($newSubscription));
            }
        }
    }

    public function render()
    {
        return view('livewire.client.subscription.subscription-item');
    }
}
