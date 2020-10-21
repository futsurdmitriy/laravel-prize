<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Models\UsersPrize;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class CheckUserTries
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
        $userPrizes = UsersPrize::where("user_id", Auth::id())
            ->orderBy('created_at', 'desc')
            ->first();
        if ($userPrizes && !$userPrizes->created_at->isNextDay()) {
            return redirect('/')->withErrors(['Try next day']);
        }
        return $next($request);
    }
}
