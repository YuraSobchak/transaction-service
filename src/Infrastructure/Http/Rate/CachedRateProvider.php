<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Rate;

use App\Infrastructure\Cache\CacheService;

final readonly class CachedRateProvider implements RateProviderInterface
{
    public function __construct(
        private RateProviderInterface $decorated,
        private CacheService $cacheService,
    ) {
    }

    public function getRate(string $currency): float
    {
        $key = $this->getKey($currency);
        $rate = $this->cacheService->get($key);

        if (!$rate) {
            $rate = $this->decorated->getRate($currency);
            $this->cacheService->set($key, $rate);
        }

        return $rate;
    }

    private function getKey(string $bin): string
    {
        return 'currency' . $bin;
    }
}
