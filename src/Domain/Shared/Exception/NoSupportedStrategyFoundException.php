<?php

declare(strict_types=1);

namespace App\Domain\Shared\Exception;

final class NoSupportedStrategyFoundException extends \Exception
{
    public function __construct(string $class)
    {
        parent::__construct(\sprintf('No supported strategy found for %s.', $class));
    }
}
