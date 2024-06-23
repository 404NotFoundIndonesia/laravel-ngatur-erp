<?php

namespace App\Enum;

enum Currency: string
{
    // Common Currencies
    case USD = 'USD'; // US Dollar
    case EUR = 'EUR'; // Euro
    case GBP = 'GBP'; // British Pound
    case JPY = 'JPY'; // Japanese Yen
    case AUD = 'AUD'; // Australian Dollar
    case CAD = 'CAD'; // Canadian Dollar
    case CHF = 'CHF'; // Swiss Franc
    case CNY = 'CNY'; // Chinese Yuan
    case SEK = 'SEK'; // Swedish Krona
    case NZD = 'NZD'; // New Zealand Dollar

    // Additional Currencies
    case INR = 'INR'; // Indian Rupee
    case BRL = 'BRL'; // Brazilian Real
    case RUB = 'RUB'; // Russian Ruble
    case ZAR = 'ZAR'; // South African Rand
    case TRY = 'TRY'; // Turkish Lira
    case MXN = 'MXN'; // Mexican Peso
    case SGD = 'SGD'; // Singapore Dollar
    case HKD = 'HKD'; // Hong Kong Dollar
    case NOK = 'NOK'; // Norwegian Krone
    case KRW = 'KRW'; // South Korean Won

    // Southeast Asia
    case IDR = 'IDR'; // Indonesian Rupiah
    case MYR = 'MYR'; // Malaysian Ringgit
    case PHP = 'PHP'; // Philippine Peso
    case THB = 'THB'; // Thai Baht
    case VND = 'VND'; // Vietnamese Dong
    case MMK = 'MMK'; // Myanmar Kyat
    case KHR = 'KHR'; // Cambodian Riel
    case LAK = 'LAK'; // Lao Kip
    case BND = 'BND'; // Brunei Dollar

    // Middle East
    case AED = 'AED'; // UAE Dirham
    case SAR = 'SAR'; // Saudi Riyal
    case QAR = 'QAR'; // Qatari Riyal
    case KWD = 'KWD'; // Kuwaiti Dinar
    case BHD = 'BHD'; // Bahraini Dinar
    case OMR = 'OMR'; // Omani Rial
    case IRR = 'IRR'; // Iranian Rial
    case JOD = 'JOD'; // Jordanian Dinar
    case LBP = 'LBP'; // Lebanese Pound

    // Example of using the enum
    public function symbol(): string
    {
        return match ($this) {
            Currency::USD => '$',
            Currency::EUR => '€',
            Currency::GBP => '£',
            Currency::JPY => '¥',
            Currency::AUD => 'A$',
            Currency::CAD => 'C$',
            Currency::CHF => 'CHF',
            Currency::CNY => '¥',
            Currency::SEK => 'kr',
            Currency::NZD => 'NZ$',
            Currency::INR => '₹',
            Currency::BRL => 'R$',
            Currency::RUB => '₽',
            Currency::ZAR => 'R',
            Currency::TRY => '₺',
            Currency::MXN => '$',
            Currency::SGD => 'S$',
            Currency::HKD => 'HK$',
            Currency::NOK => 'kr',
            Currency::KRW => '₩',
            Currency::IDR => 'Rp',
            Currency::MYR => 'RM',
            Currency::PHP => '₱',
            Currency::THB => '฿',
            Currency::VND => '₫',
            Currency::MMK => 'K',
            Currency::KHR => '៛',
            Currency::LAK => '₭',
            Currency::BND => 'B$',
            Currency::AED => 'د.إ',
            Currency::SAR => 'ر.س',
            Currency::QAR => 'ر.ق',
            Currency::KWD => 'د.ك',
            Currency::BHD => 'ب.د',
            Currency::OMR => 'ر.ع',
            Currency::IRR => '﷼',
            Currency::JOD => 'د.ا',
            Currency::LBP => 'ل.ل',
        };
    }
}
