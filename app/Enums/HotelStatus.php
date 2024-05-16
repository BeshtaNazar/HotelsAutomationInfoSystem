<?php

namespace App\Enums;

enum HotelStatus: string
{
    case NEW = 'new';
    case INACTIVE = 'inactive';
    case ACTIVE = 'active';
    case DELETED = 'deleted';
}
