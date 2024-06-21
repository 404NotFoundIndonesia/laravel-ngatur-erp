<?php

namespace App\Enum;

enum Role: string
{
    case OWNER = 'owner';
    case STAFF = 'staff';
}
