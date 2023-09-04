<?php

/** Authenticated */

use App\Core\Extensions\V2ray\Models\Inbound;
use App\Core\Extensions\V2ray\Models\Protocol;
use App\Exceptions\Api\Application\V1\NotEnoughInputArguments;
use App\Models\Option;
use App\Models\Server;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

Route::get('getConnectionConfig', [\App\Http\Controllers\Api\Application\V1\ServerController::class, 'getConnectionConfig'])->name('v2ray.getConnectionConfig');
