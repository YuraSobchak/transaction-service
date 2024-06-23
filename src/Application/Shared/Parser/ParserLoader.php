<?php

declare(strict_types=1);

namespace App\Application\Shared\Parser;

interface ParserLoader
{
    public function loadParser(string $format): ParserProvider;
}
