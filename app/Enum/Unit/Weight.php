<?php

namespace App\Enum\Unit;

enum Weight: string
{
    case MILLIGRAM = 'mg';
    case GRAM = 'g';
    case KILOGRAM = 'kg';
    case TONNE = 't';
    case OUNCE = 'oz';
    case POUND = 'lb';
}
