<?php

namespace App\Http\Controllers;

use App\Enums\ReservationStatus;
use App\Enums\RoomStatus;
use App\Models\Bed;
use App\Models\Room;
use App\Models\Hotel;
use App\Enums\HotelStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RoomController extends Controller
{
    public function listView($hotelName)
    {
        $hotel = Hotel::where('name', $hotelName)->first();
        $isActive = $hotel->status == HotelStatus::ACTIVE->value;
        if ($isActive)
            $rooms = $hotel->rooms()->where('status', RoomStatus::ACTIVE)->get();
        else
            $rooms = $hotel->rooms()->where('status', RoomStatus::NEW )->get();
        return view('hotel.room.list', ['hotelName' => $hotel->name, 'rooms' => $rooms, 'isActive' => $isActive]);
    }
    public function store(Request $request, $hotelName)
    {
        $messages = [];
        foreach ($request->get('beds') as $key => $value) {
            $messages['beds.' . $key . '.required'] = $key . ' bed count is required';
        }
        $hotel = Hotel::where('name', $hotelName)->first();
        $request->validate([
            'numberOfGuests' => ['required', 'min:1'],
            'size' => ['required', 'gt:10'],
            'priceForNight' => ['required'],
            'beds.*' => ['required'],
            'roomsCount' => ['required', 'min:1'],
        ], $messages);
        $processedRequest = $request->collect()->map(function ($item, $key) {
            if (is_null($item) || is_array($item)) {
                return $item;
            }
            return trim(strip_tags($item));
        });
        $bedsCount = 0;
        foreach ($processedRequest['beds'] as $value) {
            $bedsCount += $value;
        }
        if ($bedsCount == 0)
            return back()->withErrors(['bedsCount' => 'Beds count must be more than 0'])->withInput();
        $isActive = $hotel->status == HotelStatus::ACTIVE->value;
        for ($i = 0; $i < $processedRequest['roomsCount']; $i++) {
            $room = new Room;
            $room->number_of_guests = $processedRequest['numberOfGuests'];
            $room->is_smoking_allowed = isset($processedRequest['isSmokingAllowed']);
            $room->size = $processedRequest['size'];
            $room->measure_unit = $processedRequest['measureUnit'];
            $room->price_for_night = $processedRequest['priceForNight'];
            $room->room_type = $processedRequest['roomType'];
            if ($isActive)
                $room->status = RoomStatus::ACTIVE;
            $room->hotel_id = $hotel->id;
            $room->save();
            foreach ($processedRequest['beds'] as $key => $value) {
                if ($value != 0) {
                    $bed = Bed::where('name', $key)->first();
                    $room->beds()->attach($bed->id, ['count' => $value]);
                }
            }
        }
        return redirect()->route('room.list', ['hotelName' => $hotelName, 'rooms' => $hotel->rooms(), 'isActive' => $isActive]);
    }
    public function createView($hotelName, Room $room = null)
    {
        $roomTypes = ['Single room', 'Double room', 'Triple room', 'Quadruple room'];
        $beds = Bed::all();
        return view('hotel.room.create', ['room' => $room, 'roomTypes' => $roomTypes, 'beds' => $beds, 'hotelName' => $hotelName]);
    }
    public function update(Request $request, Room $room)
    {
        $messages = [];
        foreach ($request->get('beds') as $key => $value) {
            $messages['beds.' . $key . '.required'] = $key . ' bed count is required';
        }
        $request->validate([
            'numberOfGuests' => ['required', 'min:1'],
            'size' => ['required', 'gt:10'],
            'priceForNight' => ['required'],
            'beds.*' => ['required'],
        ], $messages);
        $hotel = Hotel::find($room->hotel_id);
        $processedRequest = $request->collect()->map(function ($item, $key) {
            if (is_null($item) || is_array($item)) {
                return $item;
            }
            return trim(strip_tags($item));
        });
        $bedsCount = 0;
        foreach ($processedRequest['beds'] as $value) {
            $bedsCount += $value;
        }
        if ($bedsCount == 0)
            return back()->withErrors(['bedsCount' => 'Beds count must be more than 0'])->withInput();
        $room->number_of_guests = $processedRequest['numberOfGuests'];
        $room->is_smoking_allowed = isset($processedRequest['isSmokingAllowed']);
        $room->size = $processedRequest['size'];
        $room->measure_unit = $processedRequest['measureUnit'];
        $room->price_for_night = $processedRequest['priceForNight'];
        $room->room_type = $processedRequest['roomType'];
        $room->save();
        foreach ($processedRequest['beds'] as $key => $value) {
            $bed = Bed::where('name', $key)->first();
            if ($value != 0) {
                if (!$room->beds()->where('bed_id', $bed->id)->exists()) {
                    $room->beds()->attach($bed->id, ['count' => $value]);
                } else if ($room->beds()->where('bed_id', $bed->id)->first()->pivot->count != $value) {
                    $room->beds()->updateExistingPivot($bed->id, ['count' => $value]);
                }
            } else {
                $room->beds()->detach($bed->id);
            }
        }
        return redirect()->route('room.list', ['hotelName' => $hotel->name]);
    }
    public function delete(Room $room)
    {
        $hotel = Hotel::find($room->hotel_id);
        $room->delete();
        return redirect()->route('room.list', ['hotelName' => $hotel->name]);
    }
    public function show($hotelName, Request $request)
    {
        $hotel = Hotel::where('name', $hotelName)->first();
        $isPreview = $hotel->status == HotelStatus::INACTIVE->value;
        if ($isPreview)
            $rooms = $hotel->rooms()->get();
        else
            $rooms = $hotel->rooms()->where('status', RoomStatus::ACTIVE->value)->get();
        return view('hotel.room.index', compact('hotel', 'isPreview', 'rooms'));
    }
    public function showAvailableRooms(Request $request, $hotelName)
    {
        $request->validate([
            'checkIn' => ['required', 'date', 'after:' . Carbon::yesterday()->format('Y-m-d')],
            'checkOut' => ['required', 'date', 'after:checkIn']
        ], [
            'checkIn.required' => 'Check-in is required',
            'checkOut.required' => 'Check-out is required'
        ]);
        $hotel = Hotel::where('name', $hotelName)->first();
        $isPreview = $hotel->status == HotelStatus::INACTIVE->value;
        $availableRooms = $hotel->rooms()->whereDoesntHave('reservations', function ($query) use ($request) {
            $query->where(function ($query) use ($request) {
                $query->whereBetween('date_from', [$request->checkIn, $request->checkOut])
                    ->orWhereBetween('date_to', [$request->checkIn, $request->checkOut]);
            })->where('status', ReservationStatus::RESERVATED->value);
        });
        if (!$isPreview)
            $availableRooms = $availableRooms->where('status', RoomStatus::ACTIVE->value);
        $isSearch = 1;
        $availableRooms = $availableRooms->get();

        return view('hotel.room.index', compact('hotel', 'isPreview', 'availableRooms', 'isSearch', 'request'));
    }
    public function deleteActive(Room $room)
    {
        $hotel = Hotel::find($room->hotel_id);
        foreach ($room->reservations()->where('status', ReservationStatus::RESERVATED)->where('date_to', '>=', Carbon::today())->get() as $reservation) {
            $reservation->status = ReservationStatus::CANCELED->value;
            $reservation->save();
        }
        $room->status = RoomStatus::DELETED;
        $room->save();
        return redirect()->route('room.list', ['hotelName' => $hotel->name]);
    }
}
