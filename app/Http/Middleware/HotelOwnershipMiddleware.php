<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class HotelOwnershipMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!is_null($request->route()->parameter('hotelName'))) {
            $hotel = Hotel::where('name', $request->route()->parameter('hotelName'))->first();
        } else {
            $hotel = $request->route()->parameter('hotel');
        }

        if ($hotel->user_id !== Auth::user()->id && Auth::user()->role != UserRole::ADMIN->value) {
            return redirect()->back();
        }
        return $next($request);
    }
}
