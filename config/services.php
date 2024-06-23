<?php

declare(strict_types=1);

use App\Application\Shared\Parser\ParserLoader;
use App\Infrastructure\FileSystem\Txt\TxtParserProvider;
use App\Infrastructure\Http\Bin\BinProviderInterface;
use App\Infrastructure\Http\Bin\LookupBinProvider;
use App\Infrastructure\Symfony\Parser\ParserLoaderAdapter;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_locator;

use Symfony\Component\DependencyInjection\ServiceLocator;

return static function (ContainerConfigurator $container) {
    $services = $container->services();

    $services
        ->defaults()
        ->private()
        ->autoconfigure()
        ->autowire()
        ->bind('$filesDir', \dirname(__DIR__) . '/files/');

    $services->load('App\\', __DIR__ . '/../src/*');

    $services->set(TxtParserProvider::class)
        ->tag('app.parser_providers', ['key' => 'txt']);

    $services
        ->set(ParserLoaderAdapter::class)
        ->args([tagged_locator('app.parser_providers', 'key')])
        ->alias(ParserLoader::class, ParserLoaderAdapter::class);

    $services
        ->set(ServiceLocator::class)
        ->args([
            ['txt' => service(TxtParserProvider::class)],
        ]);

    $services->set(BinProviderInterface::class)->class(LookupBinProvider::class);
};
