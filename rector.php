<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Php81\Rector\Array_\FirstClassCallableRector;
use Rector\Php81\Rector\Property\ReadOnlyPropertyRector;
use Rector\Php82\Rector\Class_\ReadOnlyClassRector;
use Rector\Set\ValueObject\LevelSetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/config',
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_82,
    ]);

    $rectorConfig->skip([
        ReadOnlyPropertyRector::class,
        ReadOnlyClassRector::class,
        FirstClassCallableRector::class => [
            __DIR__ . '/config/services.php',
            __DIR__ . '/config/**/services.php',
        ],
    ]);
};
