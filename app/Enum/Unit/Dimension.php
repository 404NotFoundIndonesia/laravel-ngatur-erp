<?php

namespace App\Enum\Unit;

enum Dimension: string
{
    case MILLIMETER = 'mm';
    case CENTIMETER = 'cm';
    case METER = 'm';
    case INCH = 'in';
    case FOOT = 'ft';
}
