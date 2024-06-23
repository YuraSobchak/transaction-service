<?php

declare(strict_types=1);

namespace App\Application\Shared\Parser;

interface DataLoader
{
    public function getData(string $filename): array;
}
