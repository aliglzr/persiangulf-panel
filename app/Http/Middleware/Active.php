<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Active
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->active || $request->user()->isManager())
        return $next($request);

        abort(403,"<span class='text-dark'>اکانت شما غیر فعال شده است. در صورت بروز اشتباه، لطفا به آدرس <span class='text-primary fw-bold'>solidvpn.talk@gmail.com</span> ایمیل ارسال کنید</span>");
    }
}
