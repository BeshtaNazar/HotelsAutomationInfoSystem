<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Hotel;
use App\Enums\RoomStatus;
use App\Enums\HotelStatus;
use Illuminate\Http\Request;
use App\Enums\ReservationStatus;

class SearchController extends Controller
{
    public function searchResultView(Request $request)
    {
        $areAnyChildren = false;
        foreach ($request->rooms as $room) {
            if ($room['children'] > 0) {
                $areAnyChildren = true;
                break;
            }
        }
        $matchingHotels = [];
        $hotels = Hotel::where('status', HotelStatus::ACTIVE->value)->where(function ($query) use ($request) {
            $query->where('name', 'LIKE', '%' . $request->location . '%')
                ->orWhere('country', 'LIKE', '%' . $request->location . '%')
                ->orWhere('city', 'LIKE', '%' . $request->location . '%');
        });
        if ($areAnyChildren) {
            $hotels->where('are_children_allowed', true);
        }
        $guestsRooms = [];
        foreach ($request->rooms as $key => $room)
            $guestsRooms[$key] = $room['adults'] + $room['children'];
        rsort($guestsRooms);
        $remove = [];
        foreach ($hotels->get() as $hotel) {
            $rooms = $hotel->rooms()->where('status', RoomStatus::ACTIVE->value)->orderBy('number_of_guests', 'DESC')->get();
            foreach ($rooms as $key => $room) {
                if (isset($guestsRooms[$key]) && $room->number_of_guests < $guestsRooms[$key]) {
                    $remove[] = $hotel->id;
                }
            }
        }
        $remove = array_unique($remove);
        $matchingHotels = $hotels->whereNotIn('id', $remove)->whereHas('rooms', function ($query) use ($request) {
            return $query->where(function ($query) use ($request) {
                $query->whereDoesntHave('reservations', function ($query) use ($request) {
                    return $query->where(function ($query) use ($request) {
                        $query->whereBetween('date_from', [$request->checkIn, $request->checkOut])
                            ->orWhereBetween('date_to', [$request->checkIn, $request->checkOut]);
                    })->where('status', ReservationStatus::RESERVATED->value);
                });
            });
        })->withCount('rooms')->get()->where('rooms_count', '>=', count($request->rooms));
        return view('search-result', ['hotels' => $matchingHotels, 'request' => $request]);
    }
}
