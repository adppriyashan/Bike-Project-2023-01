<?php

namespace App\Http\Middleware;

use App\Models\Bike;
use App\Models\Reservations;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class ReservationsCheck
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

        $query = Reservations::where('status', 1)->where('is_paid', 2)->where('ride_at', '<', Carbon::now()->subMinutes(15));

        //change bike available
        Bike::whereIn('id', $query->pluck('bike'))->update(['available' => 1]);
        //cancel
        $query->update(['status' => 2]);

        return $next($request);
    }
}
