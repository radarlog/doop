<?php

declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\S3;

use Aws\Credentials\Credentials;
use Aws\S3\S3ClientInterface;
use Aws\Sdk;
use Radarlog\Doop\Infrastructure\S3\Connection\Endpoint;
use Radarlog\Doop\Infrastructure\S3\Connection\Key;
use Radarlog\Doop\Infrastructure\S3\Connection\Region;

final class Connection
{
    /** @link https://docs.aws.amazon.com/sdk-for-php/v3/developer-guide/guide_configuration.html#cfg-version */
    private const LATEST_VERSION = '2006-03-01';

    /** @var Sdk */
    private $sdk;

    public function __construct(Endpoint $endpoint, Key $key, Key $secret, Region $region)
    {
        $this->sdk = new Sdk([
            'credentials' => new Credentials($key->decoded(), $secret->decoded()),
            'endpoint' => $endpoint->url(),
            'region' => $region->name(),
            'version' => self::LATEST_VERSION,
        ]);
    }

    /**
     * @throws InvalidArgument
     */
    public static function from(string $endpoint, string $key, string $secret, string $region): self
    {
        return new self(new Endpoint($endpoint), new Key($key), new Key($secret), new Region($region));
    }

    public function createS3Client(bool $usePathStyle): S3ClientInterface
    {
        return $this->sdk->createS3([
            'use_path_style_endpoint' => $usePathStyle,
        ]);
    }
}
