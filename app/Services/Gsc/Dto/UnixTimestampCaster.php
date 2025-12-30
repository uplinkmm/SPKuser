<?php

namespace App\Services\Gsc\Dto;

use Carbon\Carbon;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;
use Spatie\LaravelData\Support\Creation\CreationContext;

class UnixTimestampCaster implements Cast
{
    public function cast(
        DataProperty $property,
        mixed $value,
        array $properties,
        CreationContext $context
    ): ?Carbon {
        if (empty($value) || (int) $value === 0) {
            return null; // treat 0 as not settled
        }

        return Carbon::createFromTimestamp((int) $value);
    }
}
