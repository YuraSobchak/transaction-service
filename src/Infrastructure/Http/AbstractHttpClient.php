<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract readonly class AbstractHttpClient
{
    public function __construct(private HttpClientInterface $httpClient)
    {
    }

    protected function getJsonResponse(string $path): array
    {
        $jsonResponse = $this->httpClient->request(Request::METHOD_GET, $path, ['headers' => ['accept' => 'application/json']]);

        return \json_decode($jsonResponse->getContent(), true);
    }
}
