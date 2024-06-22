<?php

namespace App\Enum\Unit;

enum Quantity: string
{
    case UNIT = 'pcs';
    case DOZEN = 'doz';
    case GROSS = 'gr';
    case PACK = 'pk';
    case PAIR = 'pr';
    case CASE = 'case';
    case CARTON = 'ctn';
}
