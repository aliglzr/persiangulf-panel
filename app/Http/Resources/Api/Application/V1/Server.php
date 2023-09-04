<?php

namespace App\Http\Resources\Api\Application\V1;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;

class Server extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    #[ArrayShape(['ok' => "bool", 'data' => "array", 'error' => "null"])] public function toArray($request): array
    {
        return [
            'ok' => true,
            'data' => [
                $this->resource->toApplicationArray('v1')
            ],
            'error' => null
        ];
    }
}
