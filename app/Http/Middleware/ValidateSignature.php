<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Routing\Exceptions\InvalidSignatureException;
use Illuminate\Routing\Middleware\ValidateSignature as BaseMiddleware;
use Illuminate\Support\Facades\Cache;

class ValidateSignature extends BaseMiddleware
{
    /**
     * Cache manager
     *
     * @var \Illuminate\Cache\CacheManager
     */
    protected $cache;

    /**
     * Create a new ValidateSignature instance.
     *
     * @param  \Illuminate\Cache\CacheManager $cache
     */
    public function __construct()
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  bool $consume
     * @return \Illuminate\Http\Response
     *
     */
    public function handle($request, Closure $next, $consume = false)
    {
        $consume = $consume == "consume";
        if (($consume && $this->signatureConsumed($request)) || !$request->hasValidSignature()) {
            abort(404);
        }

        /** @var \Illuminate\Http\Response $response */
        $response = $next($request);

        if ($consume && $response->isSuccessful()) {
            $this->consumeSignature($request);
        }


        return $response;
    }

    /**
     * Checks if the signature was consumed
     *
     * @param  \Illuminate\Http\Request $request
     * @return bool
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function signatureConsumed(Request $request)
    {
        return Cache::store('redis')->has($this->cacheKey($request));
    }

    /**
     * Consumes the signature, marking it as unavailable
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    protected function consumeSignature(Request $request)
    {
        $ttl = $request->query('expires') ? Carbon::createFromTimestamp($request->query('expires')) : null;
        Cache::store('redis')->put($this->cacheKey($request), '', $ttl);
    }

    /**
     * Return the cache Key to check
     *
     * @param  \Illuminate\Http\Request $request
     * @return string
     */
    protected function cacheKey(Request $request)
    {
        return 'consumable|' . $request->query('signature');
    }
}