<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Service;

use App\Domain\Transaction\Transaction;

final readonly class FeeCalculator
{
    private const DECIMAL_PRECISION = 2;
    private const EUR = 'EUR';

    private const COUNTRY_CODES = [
        'AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES',
        'FI', 'FR', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU',
        'LV', 'MT', 'NL', 'PO', 'PT', 'RO', 'SE', 'SI', 'SK',
    ];

    public function calculate(Transaction $transaction, string $countryCode, float|int $rate): float
    {
        if (self::EUR === $transaction->currency) {
            $euAmount = $transaction->amount;
        } else {
            $euAmount = $rate > 0 ? ($transaction->amount / $rate) : $transaction->amount;
        }

        $commissionRate = $this->commissionRate($countryCode);

        $fee = $euAmount * $commissionRate;

        return $this->round($fee, self::DECIMAL_PRECISION);
    }

    private function commissionRate(string $countryCode): float
    {
        if (\in_array($countryCode, self::COUNTRY_CODES)) {
            return 0.01;
        }

        return 0.02;
    }

    private function round(float $value, ?int $precision = null): float
    {
        if (null === $precision) {
            return \ceil($value);
        }
        if ($precision < 0) {
            throw new \RuntimeException('Invalid precision');
        }

        $reg = $value + 0.5 / (10 ** $precision);

        if ($reg < 0) {
            throw new \RuntimeException('Invalid amount');
        }

        return \round($reg, $precision, PHP_ROUND_HALF_DOWN);
    }
}
