<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Bin;

use App\Infrastructure\Cache\CacheService;

final readonly class CachedBinProvider implements BinProviderInterface
{
    public function __construct(
        private BinProviderInterface $decorated,
        private CacheService $cacheService,
    ) {
    }

    public function getBinCountryCode(string $bin): string
    {
        $key = $this->getKey($bin);
        $countryCode = $this->cacheService->get($key);

        if (!$countryCode) {
            $countryCode = $this->decorated->getBinCountryCode($bin);
            $this->cacheService->set($key, $countryCode);
        }

        return $countryCode;
    }

    private function getKey(string $bin): string
    {
        return 'bin' . $bin;
    }
}
