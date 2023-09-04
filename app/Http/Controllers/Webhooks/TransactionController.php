<?php

namespace App\Http\Controllers\Webhooks;

use App\Core\Extensions\Alchemy\Webhook\Models\Activity;
use App\Core\Extensions\Alchemy\Webhook\Models\Event;
use App\Core\Extensions\Alchemy\Webhook\Models\Log;
use App\Core\Extensions\Alchemy\Webhook\Models\WebhookActivity;
use App\Events\TransactionUpdated;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $body = $request->body;
        $webhook = json_decode($body, true);
        $webhookActivity = new WebhookActivity();
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
                    $newActivity->fromAddress = $activity['fromAddress'] ?? null;
                    $newActivity->toAddress = $activity['toAddress'] ?? null;
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
        \Log::info(json_encode($webhookActivity));
        die();
    }
}
