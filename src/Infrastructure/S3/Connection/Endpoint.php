<?php

declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\S3\Connection;

use Radarlog\Doop\Infrastructure\S3\InvalidArgument;

final class Endpoint
{
    private string $url;

    public function __construct(string $url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw InvalidArgument::endpoint($url);
        }

        $scheme = parse_url($url, PHP_URL_SCHEME);
        $host = parse_url($url, PHP_URL_HOST);
        $port = parse_url($url, PHP_URL_PORT);

        $this->url = $this->from($scheme, $host, $port);
    }

    private function from(string $scheme, string $host, ?int $port): string
    {
        if ($port === null) {
            return sprintf('%s://%s', $scheme, $host);
        }

        return sprintf('%s://%s:%d', $scheme, $host, $port);
    }

    public function url(): string
    {
        return $this->url;
    }
}
