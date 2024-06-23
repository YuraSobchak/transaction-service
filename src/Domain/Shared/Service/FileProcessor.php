<?php

declare(strict_types=1);

namespace App\Domain\Shared\Service;

use App\Application\Shared\Parser\ParserLoader;
use App\Domain\Transaction\Service\FeeCalculator;
use App\Infrastructure\Http\Bin\BinProviderInterface;
use App\Infrastructure\Http\Rate\RateProviderInterface;
use Psr\Log\LoggerInterface;

final readonly class FileProcessor
{
    public function __construct(
        private ParserLoader $parserLoader,
        private BinProviderInterface $binProvider,
        private RateProviderInterface $rateProvider,
        private FeeCalculator $feeCalculator,
        private LoggerInterface $logger,
    ) {
    }

    public function processTransactions(string $filename): array
    {
        $parser = $this->parserLoader->loadParser(\pathinfo($filename, PATHINFO_EXTENSION));
        $transactions = $parser->getDataLoader()->getData($filename);

        $fees = [];
        foreach ($transactions as $transaction) {
            try {
                $countryCode = $this->binProvider->getBinCountryCode($transaction->bin);
                $rate = $this->rateProvider->getRate($transaction->currency);
                $fees[] = $this->feeCalculator->calculate($transaction, $countryCode, $rate);
            } catch (\Throwable) {
                $this->logger->error(\sprintf('Transaction failed with bin %s', $transaction->bin));

                continue;
            }
        }

        return $fees;
    }
}
