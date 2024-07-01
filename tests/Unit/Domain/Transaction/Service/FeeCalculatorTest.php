<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Transaction\Service;

use App\Domain\Transaction\Service\FeeCalculator;
use App\Domain\Transaction\Transaction;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class FeeCalculatorTest extends TestCase
{
    private FeeCalculator $feeCalculator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->feeCalculator = new FeeCalculator();
    }

    public static function getFeeProvider(): iterable
    {
        yield 'transaction fee for EUR' => [new Transaction('1234', 1000, 'EUR'), 1, 0.01, 10]; // commission rate 0.01
        yield 'transaction fee for USD' => [new Transaction('1234', 1000, 'USD'), 1.07, 0.02, 18.70]; // commission rate 0.02
        yield 'transaction fee for GBP' => [new Transaction('1234', 1000, 'GBP'), 0.85, 0.01, 11.77]; // commission rate 0.01
    }

    #[DataProvider('getFeeProvider')]
    public function testFeeCalculatorCalculate(
        Transaction $transaction,
        float|int $rate,
        float|int $commissionRate,
        float $expectedFee
    ): void {
        $actualFee = $this->feeCalculator->calculate($transaction, $rate, $commissionRate);

        Assert::assertEquals($expectedFee, $actualFee);
    }
}
