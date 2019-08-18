<?php
declare(strict_types=1);

namespace Radarlog\Doop\Tests\Infrastructure\S3;

use Aws\S3\S3ClientInterface;
use Radarlog\Doop\Infrastructure\S3\Connection;
use Radarlog\Doop\Tests\UnitTestCase;

class ConnectionTest extends UnitTestCase
{
    /** @var S3ClientInterface */
    private $client;

    protected function setUp(): void
    {
        parent::setUp();

        $connection = new Connection('https://user:pass@some-s3-host.dtl:42/some_region');
        $this->client = $connection->createS3();
    }

    public function testS3Region(): void
    {
        self::assertSame('some_region', $this->client->getRegion());
    }

    public function testEndpoint(): void
    {
        self::assertSame('https://some-s3-host.dtl:42', (string) $this->client->getEndpoint());
    }

    public function testStyleEndpoint(): void
    {
        self::assertTrue($this->client->getConfig('use_path_style_endpoint'));
    }

    public function testCredentials(): void
    {
        /** @var \Aws\Credentials\CredentialsInterface $credentials */
        $credentials = $this->client->getCredentials()->wait();

        self::assertSame('user', $credentials->getAccessKeyId());
        self::assertSame('pass', $credentials->getSecretKey());
    }
}
