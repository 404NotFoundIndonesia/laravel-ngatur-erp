<?php

namespace App\Enum\Unit;

enum Volume: string
{
    case MILLILITER = 'ml';
    case LITER = 'L';
    case CUBIC_CENTIMETER = 'cm³';
    case CUBIC_METER = 'm³';
    case GALLON = 'gal';
    case QUART = 'qt';
    case PINT = 'pt';
    case CUP = 'cup';
    case FLUID_OUNCE = 'fl oz';
}
