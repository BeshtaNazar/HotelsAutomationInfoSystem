<?php

namespace App\Enums;

enum RoomStatus: string
{
    case NEW = 'new';
    case INACTIVE = 'inactive';
    case ACTIVE = 'active';
    case DELETED = 'deleted';
}