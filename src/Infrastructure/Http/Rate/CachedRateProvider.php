<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Rate;

use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

final readonly class CachedRateProvider implements RateProviderInterface
{
    private const EXPIRES_AFTER = 3600;

    public function __construct(
        private RateProviderInterface $decorated,
        private TagAwareCacheInterface $currencyRatesCache,
    ) {
    }

    public function getRate(string $currency): float
    {
        try {
            return $this->currencyRatesCache->get(
                self::getCacheKey($currency),
                function (ItemInterface $item) use ($currency) {
                    $item->expiresAfter(self::EXPIRES_AFTER);

                    $articlePrices = $this->decorated->getRate($currency);

                    $item->tag([self::getGenericCacheTag()]);

                    return $articlePrices;
                }
            );
        } catch (\Throwable) {
            return $this->decorated->getRate($currency);
        }
    }

    public static function getCacheKey(string $currency): string
    {
        return \sprintf('currency-rates_%s', $currency);
    }

    public static function getGenericCacheTag(): string
    {
        return 'currency-rates';
    }
}
