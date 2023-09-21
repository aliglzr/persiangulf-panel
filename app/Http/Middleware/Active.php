<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Active
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        if ($request->user()->active)
            return $next($request);

        abort(403, "<span class='text-dark'>اکانت شما غیر فعال شده است. در صورت بروز اشتباه، لطفا به آدرس <span class='text-primary fw-bold'>solidvpn.talk@gmail.com</span> ایمیل ارسال کنید</span>");
    }
}
