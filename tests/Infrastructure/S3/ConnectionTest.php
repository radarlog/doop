<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Tests\Infrastructure\S3;

use Aws\S3\S3ClientInterface;
use Radarlog\S3Uploader\Infrastructure\S3\Connection;
use Radarlog\S3Uploader\Tests\UnitTestCase;

class ConnectionTest extends UnitTestCase
{
    /** @var S3ClientInterface */
    private $client;

    protected function setUp(): void
    {
        parent::setUp();

        $connection = new Connection('https://user:pass@some-s3-host.dtl:42');
        $this->client = $connection->createS3('some_region');
    }

    public function testS3Region(): void
    {
        self::assertSame('some_region', $this->client->getRegion());
    }

    public function testEndpoint(): void
    {
        self::assertSame('https://some-s3-host.dtl:42', (string)$this->client->getEndpoint());
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
