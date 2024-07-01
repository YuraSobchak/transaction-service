<?php

declare(strict_types=1);

namespace App\Infrastructure\FileSystem\Json;

use App\Application\Shared\Parser\ParserProvider;

final readonly class JsonParserProvider implements ParserProvider
{
    public function __construct(private JsonDataLoader $loader)
    {
    }

    public function getDataLoader(): JsonDataLoader
    {
        return $this->loader;
    }
}
