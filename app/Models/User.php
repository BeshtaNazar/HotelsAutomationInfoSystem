<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'last_name',
        'birthday',
        'phone',
        'email',
        'country',
        'password',
    ];
    public function hotels()
    {
        return $this->hasMany(Hotel::class, 'user_id');
    }
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'user_id');
    }
}
