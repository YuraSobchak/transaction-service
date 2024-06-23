<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Parser;

use App\Application\Shared\Parser\ParserLoader;
use App\Application\Shared\Parser\ParserProvider;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\DependencyInjection\ServiceLocator;

final readonly class ParserLoaderAdapter implements ParserLoader
{
    public function __construct(private ServiceLocator $locator)
    {
    }

    public function loadParser(string $format): ParserProvider
    {
        try {
            return $this->locator->get($format);
        } catch (ServiceNotFoundException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }
}
