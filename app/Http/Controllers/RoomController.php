<?php

namespace App\Http\Controllers;

use App\Models\Bed;
use App\Models\Room;
use App\Models\Hotel;
use App\Enums\HotelStatus;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function listView($hotelName)
    {
        $hotel = Hotel::where('name', $hotelName)->first();
        $rooms = $hotel->getHotelRooms()->get();
        return view('hotel.room.list', ['hotelName' => $hotel->name, 'rooms' => $rooms]);
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
        for ($i = 0; $i < $processedRequest['roomsCount']; $i++) {
            $room = new Room;
            $room->number_of_guests = $processedRequest['numberOfGuests'];
            $room->is_smoking_allowed = isset($processedRequest['isSmokingAllowed']);
            $room->size = $processedRequest['size'];
            $room->measure_unit = $processedRequest['measureUnit'];
            $room->price_for_night = $processedRequest['priceForNight'];
            $room->room_type = $processedRequest['roomType'];
            $room->hotel_id = $hotel->id;
            $room->save();
            foreach ($processedRequest['beds'] as $key => $value) {
                if ($value != 0) {
                    $bed = Bed::where('name', $key)->first();
                    $room->beds()->attach($bed->id, ['count' => $value]);
                }
            }
        }
        return redirect()->route('room.list', ['hotelName' => $hotelName, 'rooms' => $hotel->getHotelRooms()]);
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
        $hotelName = Hotel::find($room->hotel_id)->name;
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
        return redirect()->route('room.list', ['hotelName' => $hotelName]);
    }
    public function delete(Room $room)
    {
        $hotelName = Hotel::find($room->hotel_id)->name;
        $room->delete();
        return redirect()->route('room.list', ['hotelName' => $hotelName]);
    }
    public function show($hotelName)
    {
        $hotel = Hotel::where('name', $hotelName)->first();
        $isPreview = $hotel->status == HotelStatus::INACTIVE;
        return view('hotel.room.index', compact('hotel', 'isPreview'));
    }
}
