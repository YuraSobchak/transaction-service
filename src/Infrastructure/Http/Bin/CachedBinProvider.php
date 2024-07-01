<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Bin;

use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

final readonly class CachedBinProvider implements BinProviderInterface
{
    private const EXPIRES_AFTER = 3600;

    public function __construct(
        private BinProviderInterface $decorated,
        private TagAwareCacheInterface $binCountryCodesCache,
    ) {
    }

    public function getBinCountryCode(string $bin): string
    {
        try {
            return $this->binCountryCodesCache->get(
                self::getCacheKey($bin),
                function (ItemInterface $item) use ($bin) {
                    $item->expiresAfter(self::EXPIRES_AFTER);

                    $articlePrices = $this->decorated->getBinCountryCode($bin);

                    $item->tag([self::getGenericCacheTag()]);

                    return $articlePrices;
                }
            );
        } catch (\Throwable) {
            return $this->decorated->getBinCountryCode($bin);
        }
    }

    public static function getCacheKey(string $bin): string
    {
        return \sprintf('bin-country-codes_%s', $bin);
    }

    public static function getGenericCacheTag(): string
    {
        return 'bin-country-codes';
    }
}
