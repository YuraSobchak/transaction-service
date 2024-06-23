<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Rate;

interface RateProviderInterface
{
    public function getRate(string $currency): float;
}
