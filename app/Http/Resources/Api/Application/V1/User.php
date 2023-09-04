<?php

namespace App\Http\Resources\Api\Application\V1;

use App\Models\User as UserModel;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;
use Laravel\Sanctum\NewAccessToken;
use Laravel\Sanctum\PersonalAccessToken;

class User extends JsonResource
{

    protected UserModel $user;
    protected NewAccessToken $userToken;
    public function __construct(UserModel $user, NewAccessToken $userToken)
    {
        $this->user = $user;
        $this->userToken = $userToken;
        parent::__construct($user);
    }

    /**
     * Transform the resource into an array.
     *
     * @param $request
     * @return array|Arrayable|JsonSerializable
     */
    #[ArrayShape(['ok' => "bool", 'data' => "array", 'error' => "null"])] public function toArray($request): array|JsonSerializable|Arrayable
    {
        return [
            'ok' => true,
            'data' => [
                'id' => $this->user->id,
                'token' => explode('|', $this->userToken->plainTextToken)[1],
            ],
            'error' => null
        ];
    }
}
