<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Shared\Service;

use App\Application\Shared\Parser\ParserLoader;
use App\Domain\Shared\Service\FileProcessor;
use App\Domain\Transaction\Service\FeeCalculator;
use App\Domain\Transaction\Transaction;
use App\Infrastructure\FileSystem\Txt\TxtDataLoader;
use App\Infrastructure\FileSystem\Txt\TxtParserProvider;
use App\Infrastructure\Http\Bin\BinProviderInterface;
use App\Infrastructure\Http\Rate\RateProviderInterface;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Psr\Log\LoggerInterface;

class FileProcessorTest extends MockeryTestCase
{
    private ParserLoader $parserLoader;
    private BinProviderInterface $binProvider;
    private RateProviderInterface $rateProvider;
    private FeeCalculator $feeCalculator;
    private LoggerInterface $logger;
    private FileProcessor $fileProcessor;

    protected function setUp(): void
    {
        $this->parserLoader = \Mockery::mock(ParserLoader::class);
        $this->binProvider = \Mockery::mock(BinProviderInterface::class);
        $this->rateProvider = \Mockery::mock(RateProviderInterface::class);
        $this->feeCalculator = \Mockery::mock(FeeCalculator::class);
        $this->logger = \Mockery::mock(LoggerInterface::class);
        $this->fileProcessor = new FileProcessor(
            $this->parserLoader,
            $this->binProvider,
            $this->rateProvider,
            $this->feeCalculator,
            $this->logger,
        );
    }

    public function testProcessTransactions(): void
    {
        $txtParserProvider = \Mockery::mock(TxtParserProvider::class);
        $txtDataLoader = \Mockery::mock(TxtDataLoader::class);

        $this->parserLoader->shouldReceive('loadParser')->andReturn($txtParserProvider);
        $txtParserProvider->shouldReceive('getDataLoader')->andReturn($txtDataLoader);
        $txtDataLoader->shouldReceive('getData')->andReturn([
            new Transaction('1234', 100, 'EUR'),
        ]);

        $this->binProvider->shouldReceive('getBinCountryCode')->andReturn('DE');
        $this->rateProvider->shouldReceive('getRate')->andReturn(1);
        $this->feeCalculator->shouldReceive('calculate')->andReturn(1);

        $return = $this->fileProcessor->processTransactions('transactions.txt');

        self::assertEquals([1.0], $return);
        self::assertIsArray($return);
    }

    public function testProcessTransactionsFailed(): void
    {
        $txtParserProvider = \Mockery::mock(TxtParserProvider::class);
        $txtDataLoader = \Mockery::mock(TxtDataLoader::class);

        $this->parserLoader->shouldReceive('loadParser')->andReturn($txtParserProvider);
        $txtParserProvider->shouldReceive('getDataLoader')->andReturn($txtDataLoader);
        $txtDataLoader->shouldReceive('getData')->andReturn([
            new Transaction('1234', 100, 'EUR'),
        ]);

        $this->binProvider->shouldReceive('getBinCountryCode')->andThrow(new \Exception());
        $this->logger->shouldReceive('error');

        $return = $this->fileProcessor->processTransactions('transactions.txt');

        self::assertEquals([], $return);
        self::assertIsArray($return);
    }
}
