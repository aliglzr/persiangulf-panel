<?php

namespace App\Exceptions\Api\Application\V1;

use Exception;
use Illuminate\Http\JsonResponse;
use JetBrains\PhpStorm\Pure;
use Throwable;

class ApiException extends Exception
{
    protected int $httpCode;

    /**
     * @param string $message
     * @param int $code
     * @param int $httpCode
     * @param Throwable|null $previous
     */
    #[Pure] public function __construct(string $message = "An error has occurred!", int $code = 0, int $httpCode = 200,  ?Throwable $previous = null)
    {
        $this->httpCode = $httpCode;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {
        return new JsonResponse([
            'ok' => false,
            'error' => [
                'message' => $this->message,
                'code' => $this->code
            ],
        ], $this->httpCode);
    }
}
