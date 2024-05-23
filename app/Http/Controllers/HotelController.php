<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Hotel;
use App\Enums\UserRole;
use App\Enums\RoomStatus;
use App\Enums\HotelStatus;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Enums\ReservationStatus;
use Illuminate\Support\Facades\Auth;
use Monarobase\CountryList\CountryListFacade as Countries;

class HotelController extends Controller
{
    public function listView()
    {
        $hotels = Auth::user()->hotels()->where('status', HotelStatus::NEW )->get();
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
        $isActive = false;
        if (!is_null($hotel))
            $isActive = $hotel->status == HotelStatus::ACTIVE->value;
        return view('hotel.create', compact(['countries', 'hotel', 'isActive']));
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
        if ($hotel->status == HotelStatus::ACTIVE->value)
            return redirect()->route('hotel.manage')->with('success', 'Update was successful');
        return redirect()->route('room.list', ['hotelName' => $hotel->name, 'rooms' => $hotel->rooms()]);
    }
    public function uploadPhotoView($hotelName)
    {
        $hotelMedia = Hotel::where('name', $hotelName)->first()->getMedia('hotels_images');
        return view('hotel.photoUpload', ['hotelName' => $hotelName, 'hotelMedia' => $hotelMedia]);
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
        $hotel->clearMediaCollection('hotels_images');
        foreach ($request->images as $value) {
            $hotel->addMedia($value)->toMediaCollection('hotels_images');
        }
        return redirect()->route('hotel.list.confirm', ['hotelName' => $hotelName]);
    }
    public function listConfirm($hotelName)
    {
        $hotel = Hotel::where('name', $hotelName)->first();
        if ($hotel->status == HotelStatus::NEW ->value) {
            $hotel->status = HotelStatus::INACTIVE;
            foreach ($hotel->rooms()->get() as $room) {
                $room->status = RoomStatus::INACTIVE;
                $room->save();
            }
            $hotel->save();
            return redirect()->route('hotel.list')->with('success', 'Request for listing your hotel was successfully sent, you can see it in your profile');
        }
        return redirect()->route('hotel.manage')->with('success', 'Updated successfuly');
    }

    public function manageView()
    {
        $inactiveHotels = Auth::user()->hotels()->where('status', HotelStatus::INACTIVE)->get();
        $activeHotels = Auth::user()->hotels()->where('status', HotelStatus::ACTIVE)->get();
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
        $isPreview = $hotel->status == HotelStatus::INACTIVE->value;
        $isAdmin = false;
        if (Auth::check()) {
            $isAdmin = Auth::user()->role == UserRole::ADMIN->value;
        }
        return view('hotel.index', compact('hotel', 'isPreview', 'isAdmin'));
    }
    public function approve($hotelName)
    {
        $hotel = Hotel::where('name', $hotelName)->first();
        foreach ($hotel->rooms()->get() as $room) {
            $room->status = RoomStatus::ACTIVE->value;
            $room->save();
        }
        $hotel->status = HotelStatus::ACTIVE->value;
        $hotel->save();
        $user = Auth::user();
        if ($user->role == UserRole::USER->value) {
            $user->role = UserRole::OWNER;
            $user->save();
        }
        return redirect()->route('hotel.requests');
    }
    public function deleteActive(Hotel $hotel)
    {
        foreach ($hotel->rooms()->get() as $room) {
            foreach ($room->reservations()->where('status', ReservationStatus::RESERVATED)->where('date_to', '>=', Carbon::today())->get() as $reservation) {
                $reservation->status = ReservationStatus::CANCELED->value;
                $reservation->save();
            }
            $room->status = RoomStatus::DELETED->value;
            $room->save();
        }
        $hotel->status = HotelStatus::DELETED->value;
        $hotel->save();
        $user = Auth::user();
        if ($user->hotels()->where('status', HotelStatus::ACTIVE->value)->count() == 0 && $user->role == UserRole::OWNER->value)
            $user->role = UserRole::USER;
        return redirect()->route('hotel.manage')->with('success', 'Deleted successfuly');
    }
    public function showReservations($hotelName)
    {
        $hotel = Hotel::where('name', $hotelName)->first();
        $reservationsRooms = $hotel->rooms()->whereHas('reservations')->get();
        $activeReservations = collect();
        $pastReservations = collect();
        $canceledReservations = collect();
        foreach ($reservationsRooms as $room) {
            $activeReservations = $activeReservations->merge($room->reservations()->where('status', ReservationStatus::RESERVATED->value)->where('date_to', '>=', Carbon::today())->get());
            $pastReservations = $pastReservations->merge($room->reservations()->where('status', ReservationStatus::RESERVATED->value)->where('date_to', '<', Carbon::today())->get());
            $canceledReservations = $canceledReservations->merge($room->reservations()->where('status', ReservationStatus::CANCELED->value)->get());
        }
        $isHotel = true;
        return view('reservation.index', compact(['activeReservations', 'pastReservations', 'canceledReservations', 'isHotel', 'hotelName']));
    }
}
