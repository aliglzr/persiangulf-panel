<?php

namespace App\Http\Resources\Api\Application\V1;

use App\Models\ServerStatus;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Server as ServerModel;

class ServerCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'ok' => true,
            'data' => $this->collection->map(function ($server) {
                return $server->toApplicationArray('v1');
            }),
            'error' => null
        ];
    }
}
