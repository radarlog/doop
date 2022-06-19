<?php

declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\S3\Connection;

use Radarlog\Doop\Infrastructure\S3\InvalidArgument;

final class Endpoint
{
    private readonly string $url;

    public function __construct(string $url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw InvalidArgument::endpoint($url);
        }

        $scheme = (string) parse_url($url, PHP_URL_SCHEME);
        $host = (string) parse_url($url, PHP_URL_HOST);
        $port = (int) parse_url($url, PHP_URL_PORT);

        $this->url = $this->from($scheme, $host, $port);
    }

    private function from(string $scheme, string $host, int $port): string
    {
        if ($port === 0) {
            return sprintf('%s://%s', $scheme, $host);
        }

        return sprintf('%s://%s:%d', $scheme, $host, $port);
    }

    public function url(): string
    {
        return $this->url;
    }
}
