<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Bin;

use App\Infrastructure\Http\AbstractHttpClient;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

final readonly class ChargeblastBinProvider extends AbstractHttpClient implements BinProviderInterface
{
    private const URL = 'https://api.chargeblast.com/bin/';

    public function getBinCountryCode(string $bin): string
    {
        try {
            $binInfo = $this->getJsonResponse(self::URL . $bin);

            return $binInfo['a2'];
        } catch (\Throwable) {
            throw new ConflictHttpException();
        }
    }
}
