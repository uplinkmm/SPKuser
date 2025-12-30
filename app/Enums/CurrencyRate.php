<?php

namespace App\Enums;

enum CurrencyRate: int
{
    case AED = 1;
    case AMD = 1;
    case AOA = 1;
    case ARS = 1;
    case AUD = 1;
    case AZN = 1;
    case BDT = 1;
    case BGN = 1;
    case BND = 1;
    case BRL = 1;
    case CAD = 1;
    case CHF = 1;
    case CLP = 1;
    case CNY = 1;
    case COP = 1;
    case CRC = 1;
    case CZK = 1;
    case DKK = 1;
    case DZD = 1;
    case EGP = 1;
    case ETB = 1;
    case EUR = 1;
    case FRF = 1;
    case GBP = 1;
    case GC = 1;
    case GTQ = 1;
    case HKD = 1;
    case HNL = 1;
    case HRK = 1;
    case HUF = 1;
    case IDR = 1;
    case INR = 1;
    case IRR = 1;
    case JPY = 1;
    case KES = 1;
    case KHR = 1;
    case KRW = 1;
    case KSH = 1;
    case LAK = 1;
    case LBP = 1;
    case LKR = 1;
    case MAD = 1;
    case MMK = 1;
    case MNT = 1;
    case MXN = 1;
    case MYR = 1;
    case NGN = 1;
    case NOK = 1;
    case NPR = 1;
    case NTD = 1;
    case NZD = 1;
    case PEN = 1;
    case PHP = 1;
    case PKR = 1;
    case PLN = 1;
    case PTI = 1;
    case PTV = 1;
    case PYG = 1;
    case RON = 1;
    case RUB = 1;
    case SAR = 1;
    case SC = 1;
    case SEK = 1;
    case SGD = 1;
    case THB = 1;
    case TND = 1;
    case TRY = 1;
    case TWD = 1;
    case UAH = 1;
    case UGX = 1;
    case USD = 1;
    case USDT = 1;
    case UZS = 1;
    case VES = 1;
    case VND = 1;
    case ZAR = 1;
    case ZMW = 1;
    case BOB = 1;
    case UYU = 1;
    case XAF = 1;
    case CDF = 1;
    case GYD = 1;
    case TOP = 1;


    case PYG2 = 1000;
    case COP2 = 1000;
    case IDR2 = 1000;
    case IRR2 = 1000;
    case KHR2 = 1000;
    case KRW2 = 1000;
    case LBP2 = 1000;
    case MMK2 = 1000;
    case VND2 = 1000;
    case MMK3 = 100;
    public static function fromName(string $name): ?self
    {
        foreach (self::cases() as $case) {
            if ($case->name === $name) {
                return $case;
            }
        }
        return null;
        // throw new \InvalidArgumentException("Invalid currency: $name");
    }


}
