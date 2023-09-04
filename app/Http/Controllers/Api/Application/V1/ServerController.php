<?php

namespace App\Http\Controllers\Api\Application\V1;

use App\Core\Extensions\V2ray\Models\Inbound;
use App\Core\Extensions\V2ray\Models\Protocol;
use App\Core\Extensions\V2ray\Models\Response;
use App\Exceptions\Api\Application\V1\NotEnoughInputArguments;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Application\V1\Server as ServerResource;
use App\Http\Resources\Api\Application\V1\ServerCollection;
use App\Models\Option;
use App\Models\Server;
use App\Models\User;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ServerController extends Controller
{
    /**
     * @throws AuthenticationException
     */
    public function index(Request $request): ServerCollection
    {
        /** @var User $user */
        $user = $request->user();
        if($user) {
            $layer = $user->layer;
            if(! $layer) {
                return new ServerCollection(collect([]));
            }
            // FIXME: At the moment application only needs v2ray connections but later we need to get all servers
            $servers = $layer->servers()->where('active', true)->get();
            return new ServerCollection($servers);
        } else {
            throw new AuthenticationException('Unauthenticated.');
        }
    }

    /**
     * @throws AuthenticationException
     * @throws NotEnoughInputArguments
     * @throws Exception
     */
    public function getConnectionConfig(Request $request): array
    {
        /** @var User $user */
        $user = $request->user();
        if (is_null($user) || !$user->isClient()) {
            throw new AuthenticationException('Unauthenticated.');
        }
        $layer = $user->layer;

        if (is_null($layer)) {
            throw new NotFoundHttpException('Layer not found.');
        }

        if (!isset($request->serverId)) {
            throw new NotEnoughInputArguments();
        }
        $server = Server::find($request->serverId);

        if (is_null($server) || $server->layer->id != $layer->id) {
            throw new NotFoundHttpException('Server not found.');
        }
        $tls = false;
        if($request->tls == "true") {
            $tls = true;
        }
        $link = /*$server->getConnectionConfig($user, $request->v2rayProtocol,$request->transmission, $tls)*/ null;
        if($link != "") {
            return [
                'ok' => true,
                'data' => [
                    'link' => $link
                ],
                'error' => null
            ];
        }
        return [
            'ok' => false,
            'data' => null,
            'error' => [
                'message' => "Error in link generation.",
                'code' => 0
            ]
        ];

    }

    #[Pure] public function show(Server $server): ServerResource
    {
        return new ServerResource($server);
    }
}
