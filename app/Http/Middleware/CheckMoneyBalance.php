<?php

namespace App\Http\Middleware;

use App\Models\Money;
use Closure;
use Illuminate\Http\Request;

class CheckMoneyBalance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Money::first()->balance < Money::first()->start) {
            return redirect('/')->withErrors(['We are run out of money :(']);
        }
        return $next($request);
    }
}
