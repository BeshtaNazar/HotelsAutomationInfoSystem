<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Hotel;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoomOwnershipMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $room = $request->route()->parameter('room');
        $hotel = Hotel::find($room->hotel_id);
        if ($hotel->user_id !== Auth::user()->id && Auth::user()->role != UserRole::ADMIN->value) {
            return redirect()->back();
        }
        return $next($request);
    }
}
