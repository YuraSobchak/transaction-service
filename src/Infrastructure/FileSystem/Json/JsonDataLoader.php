<?php

declare(strict_types=1);

namespace App\Infrastructure\FileSystem\Json;

use App\Application\Shared\Parser\DataLoader;
use Symfony\Component\Validator\Exception\InvalidArgumentException;

final readonly class JsonDataLoader implements DataLoader
{
    private const COMMISSIONS = 'commissions';

    public function __construct(private string $filesDir)
    {
    }

    public function getData(string $filename): array
    {
        return match (\pathinfo($filename, PATHINFO_FILENAME)) {
            self::COMMISSIONS => $this->loadCommissions($filename),
            default => throw new InvalidArgumentException(),
        };
    }

    private function readRecords(string $filename): array
    {
        return \json_decode(\file_get_contents($filename), true);
    }

    private function loadCommissions(string $filename): array
    {
        $commissions = [];
        $records = $this->readRecords($this->filesDir . $filename);

        foreach ($records as $countryCode => $commission) {
            $commissions[$countryCode] = $commission;
        }

        return $commissions;
    }
}
