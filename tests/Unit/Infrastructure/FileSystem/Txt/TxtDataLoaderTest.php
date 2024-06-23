<?php

declare(strict_types=1);

namespace App\Tests\Unit\Infrastructure\FileSystem\Txt;

use App\Domain\Transaction\Transaction;
use App\Infrastructure\FileSystem\Txt\TxtDataLoader;
use PHPUnit\Framework\Assert;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Exception\InvalidArgumentException;

final class TxtDataLoaderTest extends KernelTestCase
{
    private TxtDataLoader $txtDataLoader;

    protected function setUp(): void
    {
        parent::setUp();
        $this->txtDataLoader = self::getContainer()->get(TxtDataLoader::class);
    }

    public function testGetDataTransactions(): void
    {
        $transactions = $this->txtDataLoader->getData('transactions.txt');

        Assert::assertCount(5, $transactions);
        Assert::assertContainsOnlyInstancesOf(Transaction::class, $transactions);
    }

    public function testGetDataException()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->txtDataLoader->getData('values.txt');
    }
}
