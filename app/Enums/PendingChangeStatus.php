<?php

namespace App\Enums;

enum PendingChangeStatus: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case DECLINED = 'declined';
}