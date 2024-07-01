<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Service;

use App\Domain\Transaction\Transaction;

final readonly class FeeCalculator
{
    private const DECIMAL_PRECISION = 2;
    private const EUR = 'EUR';

    public function calculate(
        Transaction $transaction,
        float|int $rate,
        float|int $commissionRate,
    ): float {
        if (self::EUR === $transaction->currency) {
            $euAmount = $transaction->amount;
        } else {
            $euAmount = $rate > 0 ? ($transaction->amount / $rate) : $transaction->amount;
        }

        $fee = $euAmount * $commissionRate;

        return $this->round($fee, self::DECIMAL_PRECISION);
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
