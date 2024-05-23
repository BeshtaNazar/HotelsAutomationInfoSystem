<?php

namespace App\Http\Controllers;

use App\Enums\ReservationStatus;
use App\Models\Payment;
use App\Models\Room;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function create()
    {
        return view('reservation.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'cardType' => 'required',
            'cardName' => ['required'],
            'cardNumber' => ['required', 'regex:/^\d{13,19}$/'],
            'cardExpirationMonth' => 'required',
            'cardExpirationYear' => 'required',
            'CVVCode' => ['required', 'regex:/^\d{3,4}$/'],
            'message' => 'nullable',
        ]);
        $processedRequest = $request->collect()->map(function ($item, $key) {
            if (is_null($item)) {
                return $item;
            }
            return trim(strip_tags($item));
        });
        $cartRooms = $_COOKIE['cartRooms'];
        $cartRooms = $cartRooms ? json_decode($cartRooms) : [];
        if (empty($cartRooms)) {
            return redirect()->route('home')->with('failure', 'Failed to reserve, cart was empty');
        }
        $roomIds = array_map(function ($room) {
            return $room->id;
        }, $cartRooms);
        $rooms = Room::whereIn('id', $roomIds)->orderBy('id')->get();
        usort($cartRooms, function ($a, $b) {
            return $a->id > $b->id;
        });
        foreach ($rooms as $index => $room) {
            $room->checkIn = $cartRooms[$index]->checkIn;
            $room->checkOut = $cartRooms[$index]->checkOut;
            if (!$room->isAvailable($room->checkIn, $room->checkOut)) {
                return redirect()->route('cart')->with('failure', 'Failed to reserve, unavailable rooms in cart');
            }
        }
        foreach ($rooms as $room) {
            $reservation = new Reservation;
            $reservation->date_from = $room->checkIn;
            $reservation->date_to = $room->checkOut;
            $reservation->message = $processedRequest['message'];
            $reservation->room_id = $room->id;
            $reservation->user_id = Auth::user()->id;
            $reservation->save();
            $payment = new Payment;
            $payment->payment_date = Carbon::today();
            $payment->amount = Carbon::parse($reservation->date_from)->diffInDays(Carbon::parse($reservation->date_to)) * $room->price_for_night;
            $payment->reservation_id = $reservation->id;
            $payment->save();
        }
        unset($_COOKIE['cartRooms']);
        setcookie('cartRooms', '', -1, '/');

        return redirect()->route('account.reservations');
    }
    public function cancel(Reservation $reservation)
    {
        $reservation->status = ReservationStatus::CANCELED->value;
        $reservation->save();
        return redirect()->back();
    }
}
