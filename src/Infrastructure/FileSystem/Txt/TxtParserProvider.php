<?php

declare(strict_types=1);

namespace App\Infrastructure\FileSystem\Txt;

use App\Application\Shared\Parser\ParserProvider;

final readonly class TxtParserProvider implements ParserProvider
{
    public function __construct(
        private TxtDataLoader $loader
    ) {
    }

    public function getDataLoader(): TxtDataLoader
    {
        return $this->loader;
    }
}
