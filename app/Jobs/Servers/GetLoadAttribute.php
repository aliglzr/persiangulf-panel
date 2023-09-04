<?php

namespace App\Jobs\Servers;

use App\Models\Layer;
use App\Models\Server;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GetLoadAttribute implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $servers = Server::where('active', true)->get();
        foreach ($servers as $server) {
            try {
                /** @var Server $server */
                $address = "http://$server->ip_address:16803/counter/index.php?pass=GhTf82mLx6sKjp1qzvcD9tI";
                $result = json_decode(file_get_contents($address), true);
                $server->udp_count = $result['udp'];
                $server->tcp_count = $result['tcp'];
                $server->save();
            } catch (\Exception $exception) {
                \Log::critical("On Get load attribute class: " . $exception->getMessage());
            }
        }
    }
}
