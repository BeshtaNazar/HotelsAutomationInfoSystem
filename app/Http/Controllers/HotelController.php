<?php

namespace App\Http\Controllers;

use App\Enums\RoomStatus;
use App\Models\User;
use App\Models\Hotel;
use App\Enums\HotelStatus;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Monarobase\CountryList\CountryListFacade as Countries;

class HotelController extends Controller
{
    public function listView()
    {
        $hotels = Auth::user()->getUserHotels()->where('status', HotelStatus::NEW )->get();
        return view('hotel.list', compact('hotels'));
    }

    public function store(Request $request)
    {
        $processedRequest = $request->collect()->map(function ($item, $key) {
            if (is_null($item)) {
                return $item;
            }
            return trim(strip_tags($item));
        });
        $hotel = new Hotel;
        $hotel->name = $processedRequest['hotelName'];
        $hotel->are_children_allowed = isset($processedRequest['areChildrenAllowed']);
        $hotel->are_pets_allowed = isset($processedRequest['arePetsAllowed']);
        $hotel->arrival_time_from = $processedRequest['arrivalTimeFrom'];
        $hotel->arrival_time_to = $processedRequest['arrivalTimeTo'];
        $hotel->departure_time_from = $processedRequest['departureTimeFrom'];
        $hotel->departure_time_to = $processedRequest['departureTimeTo'];
        $hotel->cancelation_policy_days = $processedRequest['cancelationPolicyDays'];
        $hotel->building_number = $processedRequest['buildingNumber'];
        $hotel->street = $processedRequest['street'];
        $hotel->city = $processedRequest['city'];
        $hotel->country = $processedRequest['country'];
        $hotel->postal_code = $processedRequest['postalCode'];
        $hotel->iban = $processedRequest['iban'];
        $hotel->user_id = Auth::user()->id;
        $hotel->save();
        return redirect()->route('room.list', ['hotelName' => $hotel->name]);
    }
    public function delete(Hotel $hotel)
    {
        $hotel->clearMediaCollection('hotels_images');
        $hotel->delete();
        return redirect()->back();
    }
    public function createView($hotelName = null)
    {
        $countries = Countries::getList('en');
        $hotel = Hotel::where('name', $hotelName)->first();
        return view('hotel.create', compact(['countries', 'hotel']));
    }
    public function update(Request $request, Hotel $hotel)
    {
        $processedRequest = $request->collect()->map(function ($item, $key) {
            if (is_null($item)) {
                return $item;
            }
            return trim(strip_tags($item));
        });

        $hotel->name = $processedRequest['hotelName'];
        $hotel->are_children_allowed = isset($processedRequest['areChildrenAllowed']);
        $hotel->are_pets_allowed = isset($processedRequest['arePetsAllowed']);
        $hotel->arrival_time_from = $processedRequest['arrivalTimeFrom'];
        $hotel->arrival_time_to = $processedRequest['arrivalTimeTo'];
        $hotel->departure_time_from = $processedRequest['departureTimeFrom'];
        $hotel->departure_time_to = $processedRequest['departureTimeTo'];
        $hotel->cancelation_policy_days = $processedRequest['cancelationPolicyDays'];
        $hotel->building_number = $processedRequest['buildingNumber'];
        $hotel->street = $processedRequest['street'];
        $hotel->city = $processedRequest['city'];
        $hotel->country = $processedRequest['country'];
        $hotel->postal_code = $processedRequest['postalCode'];
        $hotel->iban = $processedRequest['iban'];
        $hotel->save();
        return redirect()->route('room.list', ['hotelName' => $hotel->name, 'rooms' => $hotel->getHotelRooms()]);

    }
    public function uploadPhotoView($hotelName)
    {
        return view('hotel.photoUpload', ['hotelName' => $hotelName]);
    }
    public function uploadPhotoStore($hotelName, Request $request)
    {
        $request->validate([
            'images' => ['required', 'array', 'min:5', 'max:5']
        ], [
            'images.min' => 'Please upload 5 images',
            'images.max' => 'Please upload 5 images'
        ]);
        $hotel = Hotel::where('name', $hotelName)->first();
        foreach ($request->images as $value) {
            $hotel->addMedia($value)->toMediaCollection('hotels_images');
        }
        return redirect()->route('hotel.list.confirm', ['hotelName' => $hotelName]);
    }
    public function listConfirm($hotelName)
    {
        $hotel = Hotel::where('name', $hotelName)->first();
        $hotel->status = HotelStatus::INACTIVE;
        foreach ($hotel->getHotelRooms()->get() as $room) {
            $room->status = RoomStatus::INACTIVE;
            $room->save();
        }
        $hotel->save();
        return redirect()->route('hotel.list')->with('success', 'Request for listing your hotel was successfully sent, you can see it in your profile');
    }

    public function manageView()
    {
        $inactiveHotels = Auth::user()->getUserHotels()->where('status', HotelStatus::INACTIVE)->get();
        $activeHotels = Auth::user()->getUserHotels()->where('status', HotelStatus::ACTIVE)->get();
        return view('hotel.manage', compact(['inactiveHotels', 'activeHotels']));
    }
    public function requestsView()
    {
        $inactiveHotels = Hotel::where('status', HotelStatus::INACTIVE)->get();
        return view('hotel.requests', compact('inactiveHotels'));
    }
    public function show($hotelName)
    {
        $hotel = Hotel::where('name', $hotelName)->first();
        $isPreview = $hotel->status == HotelStatus::INACTIVE;
        return view('hotel.index', compact('hotel', 'isPreview'));
    }
}
