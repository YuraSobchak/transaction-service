<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Rate;

use App\Infrastructure\Http\AbstractHttpClient;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

final readonly class FrankfurterRateProvider extends AbstractHttpClient implements RateProviderInterface
{
    private const EUR = 'EUR';
    private const URL = 'https://api.frankfurter.app/latest';

    public function getRate(string $currency): float
    {
        try {
            if (self::EUR === $currency) {
                return 1;
            }

            $rates = $this->getJsonResponse(self::URL)['rates'];

            return (float)$rates[$currency];
        } catch (\Throwable) {
            throw new ConflictHttpException();
        }
    }
}
