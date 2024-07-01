<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Service;

use App\Application\Shared\Parser\ParserLoader;

final readonly class CommissionProvider
{
    private const COMMISSIONS_FILE = 'commissions.json';
    private const DEFAULT = 'default';

    public function __construct(private ParserLoader $parserLoader)
    {
    }

    public function getAll(): array
    {
        $parser = $this->parserLoader->loadParser(\pathinfo(self::COMMISSIONS_FILE, PATHINFO_EXTENSION));

        return $parser->getDataLoader()->getData(self::COMMISSIONS_FILE);
    }

    public function getByCountryCode(array $commissions, string $countryCode): float|int
    {
        return $commissions[$countryCode] ?? $commissions[self::DEFAULT];
    }
}
