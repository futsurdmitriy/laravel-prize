<?php

namespace App\Http\Middleware;

use App\Models\PrizeItem;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CheckPrizeItemsLeft
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
        $prizesCount = PrizeItem::all()->where('user_id', null)->count();
        if ($prizesCount <= 0) {
            return redirect('/')->withErrors(['There are no prizes left, sorry :(']);
        }
        return $next($request);
    }
}
