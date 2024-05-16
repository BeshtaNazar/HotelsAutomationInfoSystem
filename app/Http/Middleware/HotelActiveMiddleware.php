<?php

namespace App\Http\Middleware;

use App\Enums\HotelStatus;
use Closure;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HotelActiveMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $hotel = Hotel::where('name', $request->route()->parameter('hotelName'))->first();
        if ($hotel->status != HotelStatus::ACTIVE->value)
            return redirect()->back();
        return $next($request);
    }
}
