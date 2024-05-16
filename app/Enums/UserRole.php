<?php

namespace App\Enums;

enum UserRole: string
{
    case USER = 'user';
    case OWNER = 'owner';
    case ADMIN = 'admin';
}
