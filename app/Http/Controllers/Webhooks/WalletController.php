<?php

namespace App\Http\Controllers\Webhooks;

use App\Core\Extensions\Alchemy\Webhook\Models\Activity;
use App\Core\Extensions\Alchemy\Webhook\Models\Event;
use App\Core\Extensions\Alchemy\Webhook\Models\Log;
use App\Core\Extensions\Alchemy\Webhook\Models\WebhookActivity;
use App\Core\Financial\CryptoCurrencies\Ethereum;
use App\Events\TransactionUpdated;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Notifications\BalanceNotifications\TransactionReceivedNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index(Request $request)
    {
        if ($_SERVER['HTTP_X_FORWARDED_FOR'] != '54.236.136.17' && $_SERVER['HTTP_X_FORWARDED_FOR'] != '34.237.24.169'){
            abort(404);
        }
        $body = file_get_contents('php://input');
        $webhookActivity = $this->retrieveWebhookActivity($body);

        /** @var Activity $activity */
        foreach ($webhookActivity->event->activity as $activity) {
            /** @var Wallet $userWallet */
            $userWallet = Wallet::where('address', $activity->toAddress)->first();
            if($userWallet) {
                $transactionId = $activity->hash;
                $exchangeRate = Ethereum::getPrice('USD');
                $amount = round(floatval($activity->value) * $exchangeRate, 2);
                // TODO: Check ethereum blockchain transaction status before database update



                if (is_null(Payment::where('blockchain_transaction_id',$transactionId)->first())){
                    $transaction = Transaction::create([
                        'amount' => $amount,
                        'data' => json_encode($activity, JSON_UNESCAPED_SLASHES),
                        'wallet_id' => $userWallet->id,
                        'user_id' => $userWallet->user_id,
                        'status' => 'pending',
                    ]);

                    $payment = $transaction->payment()->create([
                        'status' => 'pending',
                        'transaction_id' => $transaction->id,
                        'wallet_id' => $transaction->wallet_id,
                        'user_id' => $transaction->user_id,
                        'exchange_rate' => $exchangeRate,
                        'value' => $activity->value,
                        'blockchain_transaction_id' => $transactionId,
                    ]);

                    $user = $userWallet->user;

                    $user->notify(new TransactionReceivedNotification($transaction));
                }
            }
        }

        \Log::info(json_encode($webhookActivity));
        die();
    }


    // TODO : check webhook validation hash , so anyone cannot submit a webhook

    private function retrieveWebhookActivity(mixed $body)
    {
        $webhook = json_decode($body, true);
        $webhookActivity = new WebhookActivity();
        \Illuminate\Support\Facades\Log::info($body);
        $webhookActivity->webhookId = $webhook['webhookId'];
        $webhookActivity->id = $webhook["id"];
        $webhookActivity->createdAt = \DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime(substr($webhook['createdAt'], '0', 19))));
        $webhookActivity->type = $webhook['type'];
        $event = new Event();
        $event->network = $webhook['event']['network'];
        if ($webhookActivity->type == "ADDRESS_ACTIVITY") {
            {
                $event->activity = collect([]);
                foreach ($webhook['event']['activity'] as $activity) {
                    $newActivity = new Activity();
                    $newActivity->blockNum = $activity['blockNum'] ?? null;
                    $newActivity->hash = $activity['hash'] ?? null;
                    $newActivity->category = $activity['category'] ?? null;
                    $newActivity->fromAddress = strtolower($activity['fromAddress']) ?? null;
                    $newActivity->toAddress = strtolower($activity['toAddress']) ?? null;
                    $newActivity->value = $activity['value'] ?? null;
                    $newActivity->erc721TokenId = $activity['erc721TokenId'] ?? null;
                    $newActivity->erc1155Metadata = $activity['erc1155Metadata'] ?? null;
                    $newActivity->asset = $activity['asset'] ?? null;
                    $newActivity->rawContract = $activity['rawContract'] ?? null;
                    $newActivity->typeTraceAddress = $activity['typeTraceAddress'] ?? null;
                    $log = new Log();
                    $log->address = $activity['log']['address'] ?? null;
                    $log->removed = $activity['log']['removed'] ?? null;
                    $log->data = $activity['log']['data'] ?? null;
                    $log->topics = $activity['log']['topics'] ?? null;
                    $newActivity->log = $log;
                    $event->activity->push($newActivity);
                }
            }
        }
        $webhookActivity->event = $event;
        return $webhookActivity;
    }
}
