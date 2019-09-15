<?php
declare(strict_types=1);

namespace Radarlog\Doop\Tests\Infrastructure\S3;

use Aws\Credentials\CredentialsInterface;
use Radarlog\Doop\Infrastructure\S3;
use Radarlog\Doop\Infrastructure\S3\Connection;
use Radarlog\Doop\Tests\UnitTestCase;

class ConnectionTest extends UnitTestCase
{
    private const ENDPOINT = 'http://host:42';
    private const KEY = 'key';
    private const SECRET = 'secret';
    private const REGION = 'region';

    public function testFrom(): void
    {
        $endpoint = new Connection\Endpoint(self::ENDPOINT);
        $key = new Connection\Key(self::KEY);
        $secret = new Connection\Key(self::SECRET);
        $region = new Connection\Region(self::REGION);

        $connection1 = new Connection($endpoint, $key, $secret, $region);
        $connection2 = Connection::from(self::ENDPOINT, self::KEY, self::SECRET, self::REGION);

        self::assertEquals($connection1, $connection2);
    }

    public function testRegion(): void
    {
        $connection = Connection::from(self::ENDPOINT, self::KEY, self::SECRET, self::REGION);

        $client = $connection->createS3Client(S3\Client::USE_PATH_STYLE);

        self::assertSame(self::REGION, $client->getRegion());
    }

    public function testEndpoint(): void
    {
        $connection = Connection::from(self::ENDPOINT, self::KEY, self::SECRET, self::REGION);

        $client = $connection->createS3Client(S3\Client::USE_PATH_STYLE);

        self::assertSame(self::ENDPOINT, (string) $client->getEndpoint());
    }

    public function testCredentials(): void
    {
        $connection = Connection::from(self::ENDPOINT, self::KEY, self::SECRET, self::REGION);

        $client = $connection->createS3Client(S3\Client::USE_PATH_STYLE);

        /** @var CredentialsInterface $credentials */
        $credentials = $client->getCredentials()->wait();

        self::assertSame(self::KEY, $credentials->getAccessKeyId());
        self::assertSame(self::SECRET, $credentials->getSecretKey());
    }
}
