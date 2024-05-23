<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Room;

class CartController extends Controller
{
    public function index()
    {
        $cartRooms = $_COOKIE['cartRooms'];
        $cartRooms = $cartRooms ? json_decode($cartRooms) : [];
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
            $room->isAvailable = $room->isAvailable($room->checkIn, $room->checkOut);
        }
        return view('cart', compact('rooms'));
    }
}
