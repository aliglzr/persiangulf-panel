<?php

namespace App\Http\Controllers\Manage;

use App\Core\Extensions\Telegram\Bot\Api;
use App\DataTables\Payment\PaymentsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\BalanceNotifications\IncreaseBalanceNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;

class PaymentController extends Controller
{
    private $data = [];

    public function index(PaymentsDataTable $dataTable)
    {
        return $dataTable->render('pages.payment.index');
    }

    public function callback(Request $request)
    {
        if (isset($request->Authority)) {
            $payment = Payment::where('gateway_transaction_id', $request->Authority)->first();
            if (!$payment || !isset($request->Status)) {
                Log::error("Payment or status is not sent");
                return redirect(route('dashboard'));
            }
            $this->data = $payment->data;
            if ($request->Status == "OK") {
                try {
                    \DB::transaction(function () use ($request, $payment) {
                        $payment->status = 'paid';
                        $transaction = new Transaction();
                        $transaction->amount = $payment->amount;
                        $transaction->user_id = $payment->user_id;
                        $transaction->balance_before_transaction = $payment->user->balance;
                        $transaction->balance_after_transaction = $transaction->balance_before_transaction + $transaction->amount;
                        $transaction->save();
                        $payment->transaction_id = $transaction->id;
                        $payment->data = $request->all();
                        $receipt = \Shetabit\Payment\Facade\Payment::amount($payment->amount)->transactionId($payment->gateway_transaction_id)->verify();
                        $payment->user->increment('balance', $payment->amount);
                        $payment->reference_id = $receipt->getReferenceId();
                        $payment->save();
                        $agents_profit_percent = json_decode(Option::get('agents_profit_percent'), true);
                        if ($payment->user->isAgent() && !empty(Option::get('agent_profit_status')) && !empty($agents_profit_percent)) {
                            foreach ($agents_profit_percent as $key => $profit_percent) {
                                if (isset($profit_percent['percent'])) {
                                    $profit_percent = intval($profit_percent['percent']);
                                    if ($profit_percent > 0) {
                                        $introducer = User::getIntroducerByLevel($payment->user, $key + 1);
                                        if (is_null($introducer) || !$introducer?->isAgent()) {
                                            break;
                                        }
                                        $profit_amount = round(($payment->amount * $profit_percent) / 100);
                                        $introducer_transaction = $introducer->transactions()->create([
                                            'amount' => $profit_amount,
                                            'data' => json_encode(['message' => "سود افزایش اعتبار کاربر " . $payment->user->full_name . ' با نام کاربری ' . $payment->user->username . ' با شماره شناسه ' . $payment->id]),
                                            'balance_before_transaction' => $introducer->balance,
                                            'balance_after_transaction' => $introducer->balance + $profit_amount,
                                        ]);
                                        $introducer->increment('balance', $profit_amount);
                                        // send notifications to them if they verified their emails
                                    }
                                }
                            }
                        }
                        if ($payment->user->hasVerifiedEmail()) {
                            $payment->user->notify(new IncreaseBalanceNotification($transaction));
                        }
                        session()->put('payment', 'ok');
                        session()->put('payment-reference-id', $receipt->getReferenceId());
                        session()->put('payment-amount', $payment->amount);
                    }, 3);
                    if($payment->user->tid != null) {
                        $bot = new Api(Option::get('sales_bot_token') ?? config('services.telegram-bot-api.token'));
                        if (isset($this->data['bot_message_id'])) {
                            $bot->deleteMessage([
                                'chat_id' => $payment->user->tid,
                                'message_id' => $this->data['bot_message_id'],
                            ]);
                        }
                        $amount = convertNumbers(number_format($payment->amount));
                        $bot->sendMessage([
                            'chat_id' => $payment->user->tid,
                            'text' => "✅ پرداخت شما با موفقیت انجام شد.\n🔹 مبلغ $amount تومان به حساب کاربری شما اضافه شد.",
                            'reply_markup' => [
                                'resize_keyboard' => true,
                                'inline_keyboard' => [
                                    [
                                        ["text" => "➡️ بازگشت", "callback_data" => "main"],
                                    ],
                                ]
                            ]
                        ]);
                    }
                    auth()->loginUsingId($payment->user->id);
                    Log::error("login is not sent");
                    return redirect(route('dashboard'));
                } catch (InvalidPaymentException|\Exception|\Throwable $exception) {
                    session()->put('payment', 'nok');
                    \Log::critical($exception->getMessage());
                    if ($exception instanceof InvalidPaymentException) {
                        session()->put('payment-nok-message', $exception->getMessage());
                    }
                }
            } else if ($request->Status == "NOK") {
                session()->put('payment', 'nok');
            }
            try {
                \DB::transaction(function () use ($request, $payment) {
                    $payment->status = 'rejected';
                    $payment->data = $request->all();
                    $payment->save();
                });
                if ($payment->user->tid != null) {
                    $bot = new Api(Option::get('sales_bot_token') ?? config('services.telegram-bot-api.token'));
                    if (isset($this->data['bot_message_id'])) {
                        $bot->deleteMessage([
                            'chat_id' => $payment->user->tid,
                            'message_id' => $this->data['bot_message_id'],
                        ]);
                    }
                    $bot->sendMessage([
                        'chat_id' => $payment->user->tid,
                        'text' => "❗️ عملیات پرداخت ناموفق بود.\n⚠️ در صورت برداشت وجه از حساب بانکی، مبلغ برداشت شده تا ۴۸ ساعت آینده به حساب شما برگشت داده خواهد شد.",
                        'reply_markup' => [
                            'resize_keyboard' => true,
                            'inline_keyboard' => [
                                [
                                    ["text" => "➡️ بازگشت", "callback_data" => "main"],
                                ],
                            ]
                        ]
                    ]);
                }
            } catch (\Throwable $e) {
                \Log::critical($e->getMessage());
            }
        }
        Log::error("Authority is not sent");
        return redirect(route('dashboard'));
    }
}
