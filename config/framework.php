<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $configurator): void {
    $configurator->extension(
        'framework',
        [
            'test' => true,
            'session' => [
                'storage_factory_id' => 'session.storage.factory.mock_file',
            ],
            'cache' => [
                'default_redis_provider' => 'redis://127.0.0.1:6379',
                'pools' => [
                    'currency_rates.cache' => [
                        'adapter' => 'cache.adapter.redis',
                        'provider' => 'cache.default_redis_provider',
                    ],
                    'bin_country_codes.cache' => [
                        'adapter' => 'cache.adapter.redis',
                        'provider' => 'cache.default_redis_provider',
                    ],
                ],
            ],
        ],
    );
};
