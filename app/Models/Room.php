<?php

namespace App\Models;

use App\Enums\ReservationStatus;
use Carbon\Carbon;
use App\Enums\RoomStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;
    public function beds()
    {
        return $this->belongsToMany(Bed::class)->withPivot('count');
    }
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'room_id');
    }
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
    public function isActive()
    {
        return $this->status == RoomStatus::ACTIVE->value;
    }

    public function isAvailable($checkIn, $checkOut)
    {
        if (!$this->isActive())
            return false;
        if ($this->reservations()->count() != 0) {
            return true;
        }
        if (Carbon::parse($checkIn)->lessThan(Carbon::today())) {
            return false;
        }
        return $this->reservations()->where('status', ReservationStatus::RESERVATED->value)->where(function ($query) use ($checkIn, $checkOut) {
            $query->whereBetween('date_from', [$checkIn, $checkOut])
                ->orWhereBetween('date_to', [$checkIn, $checkOut])->count() == 0;
        });
    }
}
