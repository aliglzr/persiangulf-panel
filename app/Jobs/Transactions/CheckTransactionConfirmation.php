<?php

namespace App\Jobs\Transactions;

use App\Core\Extensions\Alchemy\API;
use App\Core\Financial\CryptoCurrencies\Ethereum;
use App\Events\TransactionUpdated;
use App\Models\Payment;
use App\Notifications\BalanceNotifications\IncreaseBalanceNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckTransactionConfirmation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Determine the time at which the job should timeout.
     * @return \DateTime
     */
    public function retryUntil(): \DateTime
    {
        return now()->addMinutes(2);
    }

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->checkEthereumConfirmations();
    }

    /**
     *check every payments , so if a payment's transaction is confirmed , payment and transaction status will
     * update to paid , and user balance will increase , and notify The user that the transaction get confirmed successfully
     *
     *  Note : this function called as scheduled job in app/Console/Kernel.php
     */
    private function checkEthereumConfirmations()
    {
        /** @var Payment $pendingPayments */
        $pendingPayments = Payment::where('status','pending')->get();
        /** @var Payment $payment */
        foreach ($pendingPayments as $payment){
            $transaction = $payment->transaction;
            $transactionBlockConfirmations = $transaction->getBlockConfirmations();
            if ($transactionBlockConfirmations > Ethereum::$requiredConfirmations){
                $payment->status = 'paid';
                $transaction->status = 'paid';
                $payment->save();
                $transaction->balance_before_transaction = $payment->user->balance;
                $payment->user->increment('balance',$transaction->amount);
                $transaction->balance_after_transaction = $payment->user->balance;
                $transaction->save();
                TransactionUpdated::dispatch($transaction);
                if ($payment->user->hasVerifiedEmail()){
                $payment->user->notify(new IncreaseBalanceNotification($transaction));
                }
            }
        }
    }
}
