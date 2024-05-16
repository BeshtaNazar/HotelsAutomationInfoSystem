<?php

namespace App\Enums;

enum ReservationStatus: string
{
    case RESERVATED = 'reservated';
    case CANCELED = 'canceled';
}
