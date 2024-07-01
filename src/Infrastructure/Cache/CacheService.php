<?php

declare(strict_types=1);

namespace App\Infrastructure\Cache;

use Predis\Client;

final class CacheService
{
    private Client $redis;

    public function __construct()
    {
        $this->redis = new Client([
            'scheme' => 'tcp',
            'host' => '127.0.0.1',
            'port' => 6379,
        ]);
    }

    public function get(string $key): mixed
    {
        $data = $this->redis->get($key);

        if (null !== $data) {
            // Data found in the cache
            return \unserialize($data);
        }

        // Data not found in the cache
        return null;
    }

    public function set(string $key, mixed $data, int $ttl = 3600): void
    {
        // Serialize the data before storing it in the cache
        $data = \serialize($data);
        $this->redis->setex($key, $ttl, $data);
    }

    public function delete(string $key): void
    {
        $this->redis->del($key);
    }
}
