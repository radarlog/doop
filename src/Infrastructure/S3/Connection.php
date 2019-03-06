<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Infrastructure\S3;

use Aws\Credentials;
use Aws\S3\S3ClientInterface;
use Aws\Sdk;

final class Connection
{
    /** @link https://docs.aws.amazon.com/sdk-for-php/v3/developer-guide/guide_configuration.html#cfg-version */
    private const LATEST_VERSION = '2006-03-01';

    /** @var Sdk */
    private $sdk;

    /** @var string */
    private $region;

    public function __construct(string $dsn)
    {
        $this->sdk = new Sdk([
            'credentials' => $this->credentialsFromDsn($dsn),
            'endpoint' => $this->endpointFromDsn($dsn),
            'use_path_style_endpoint' => true,
            'version' => self::LATEST_VERSION,
        ]);

        $this->region = $this->regionFromDsn($dsn);
    }

    /**
     * @link https://docs.aws.amazon.com/general/latest/gr/rande.html#s3_region
     */
    public function createS3(): S3ClientInterface
    {
        return $this->sdk->createS3([
            'region' => $this->region,
        ]);
    }

    private function credentialsFromDsn(string $dsn): Credentials\CredentialsInterface
    {
        $user = parse_url($dsn, PHP_URL_USER);
        $pass = parse_url($dsn, PHP_URL_PASS);

        return new Credentials\Credentials($user, $pass);
    }

    private function endpointFromDsn(string $dsn): string
    {
        $scheme = parse_url($dsn, PHP_URL_SCHEME);
        $host = parse_url($dsn, PHP_URL_HOST);
        $port = parse_url($dsn, PHP_URL_PORT) ?? 443;

        return sprintf('%s://%s:%d', $scheme, $host, $port);
    }

    private function regionFromDsn(string $dsn): string
    {
        $region = parse_url($dsn, PHP_URL_PATH);

        return ltrim($region, '/');
    }
}
