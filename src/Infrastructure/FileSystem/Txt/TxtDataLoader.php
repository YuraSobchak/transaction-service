<?php

declare(strict_types=1);

namespace App\Infrastructure\FileSystem\Txt;

use App\Application\Shared\Parser\DataLoader;
use App\Domain\Transaction\Transaction;
use Symfony\Component\Validator\Exception\InvalidArgumentException;

final readonly class TxtDataLoader implements DataLoader
{
    private const TRANSACTIONS = 'transactions';

    public function __construct(private string $filesDir)
    {
    }

    public function getData(string $filename): array
    {
        return match (\pathinfo($filename, PATHINFO_FILENAME)) {
            self::TRANSACTIONS => $this->loadTransactions($filename),
            default => throw new InvalidArgumentException(),
        };
    }

    private function readRecords(string $filename): array
    {
        $records = [];

        foreach (\explode("\n", \file_get_contents($filename)) as $row) {
            if (empty($row)) {
                continue;
            }

            $records[] = $row;
        }

        return $records;
    }

    /**
     * @return Transaction[]
     */
    private function loadTransactions(string $filename): array
    {
        $transactions = [];
        $records = $this->readRecords($this->filesDir . $filename);

        foreach ($records as $record) {
            $transaction = \json_decode((string)$record);
            $transactions[] = new Transaction($transaction->bin, (float)$transaction->amount, $transaction->currency);
        }

        return $transactions;
    }
}
