<?php

declare(strict_types=1);

namespace App\Application\Shared\Parser;

interface ParserProvider
{
    public function getDataLoader(): DataLoader;
}
