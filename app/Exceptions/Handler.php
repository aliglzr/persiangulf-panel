<?php

namespace App\Exceptions;

use ErrorException;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if($e instanceof NotFoundHttpException) {
            if($request->expectsJson()) {
                return new JsonResponse([
                    'ok' => false,
                    'data' => null,
                    'error' => [
                        'message' => $e->getMessage() ?? 'Route not found.',
                        'code' => 0,
                    ]
                ], 404);
            }
        } else if($e instanceof AuthenticationException) {
            if($request->expectsJson()) {
                return new JsonResponse([
                    'ok' => false,
                    'data' => null,
                    'error' => [
                        'message' => 'Unauthenticated.',
                        'code' => 0,
                    ]
                ], 401);
            }
        } else if($e instanceof MethodNotAllowedHttpException) {
            if($request->expectsJson()) {
                return new JsonResponse([
                    'ok' => false,
                    'data' => null,
                    'error' => [
                        'message' => 'Method not allowed.',
                        'code' => 0,
                    ]
                ], 405);
            }
        } else if($e instanceof ErrorException) {
            if($request->expectsJson()) {
                return new JsonResponse([
                    'ok' => false,
                    'data' => null,
                    'error' => [
                        'message' => $e->getMessage(),
                        'code' => 0,
                    ]
                ], 500);
            }
        }
        return parent::render($request, $e); // TODO: Change the autogenerated stub
    }
}
