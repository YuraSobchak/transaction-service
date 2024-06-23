<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Bin;

interface BinProviderInterface
{
    public function getBinCountryCode(string $bin): string;
}
