<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Bin;

use App\Infrastructure\Http\AbstractHttpClient;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

final readonly class LookupBinProvider extends AbstractHttpClient implements BinProviderInterface
{
    private const URL = 'https://lookup.binlist.net/';

    public function getBinCountryCode(string $bin): string
    {
        try {
            $binInfo = $this->getJsonResponse(self::URL . $bin);

            return $binInfo['country']['alpha2'];
        } catch (\Throwable) {
            throw new ConflictHttpException();
        }
    }
}
