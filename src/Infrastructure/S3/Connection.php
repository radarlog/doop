<?php

declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\S3;

use AsyncAws\Core\Configuration;
use AsyncAws\Core\Credentials\Credentials;
use Radarlog\Doop\Infrastructure\S3\Connection\Endpoint;
use Radarlog\Doop\Infrastructure\S3\Connection\Key;
use Radarlog\Doop\Infrastructure\S3\Connection\Region;

final class Connection
{
    private readonly Configuration $configuration;

    public function __construct(Endpoint $endpoint, Key $key, Key $secret, Region $region)
    {
        $credentials = new Credentials($key->decoded(), $secret->decoded());

        $this->configuration = Configuration::create([
            'accessKeyId' => $credentials->getAccessKeyId(),
            'accessKeySecret' => $credentials->getSecretKey(),
            'endpoint' => $endpoint->url(),
            'pathStyleEndpoint' => true,
            'region' => $region->name(),
        ]);
    }

    /**
     * @throws InvalidArgument
     */
    public static function from(string $endpoint, string $key, string $secret, string $region): self
    {
        return new self(new Endpoint($endpoint), new Key($key), new Key($secret), new Region($region));
    }

    public function configuration(): Configuration
    {
        return $this->configuration;
    }
}
