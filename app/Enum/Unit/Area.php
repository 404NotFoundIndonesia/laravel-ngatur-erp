<?php

namespace App\Enum\Unit;

enum Area: string
{
    case SQUARE_MILLIMETER = 'mm²';
    case SQUARE_CENTIMETER = 'cm²';
    case SQUARE_METER = 'm²';
    case SQUARE_INCH = 'in²';
    case SQUARE_FOOT = 'ft²';
}
