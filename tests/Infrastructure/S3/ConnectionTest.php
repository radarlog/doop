<?php
declare(strict_types=1);

namespace Radarlog\Doop\Tests\Infrastructure\S3;

use Aws\S3\S3ClientInterface;
use Radarlog\Doop\Infrastructure\S3;
use Radarlog\Doop\Tests\UnitTestCase;

class ConnectionTest extends UnitTestCase
{
    /** @var S3ClientInterface */
    private $client;

    /** @var S3\Connection */
    private $connection;

    protected function setUp(): void
    {
        parent::setUp();

        $this->connection = new S3\Connection('https://user:pass@some-s3-host.dtl:42/some_region');
        $this->client = $this->connection->createS3Client(S3\Client::PATH_STYLE);
    }

    public function testS3Region(): void
    {
        self::assertSame('some_region', $this->client->getRegion());
    }

    public function testEndpoint(): void
    {
        self::assertSame('https://some-s3-host.dtl:42', (string)$this->client->getEndpoint());
    }

    public function styleEndpointProvider(): iterable
    {
        yield [S3\Client::PATH_STYLE];
        yield [S3\Client::HOST_STYLE];
    }

    /**
     * @dataProvider styleEndpointProvider
     */
    public function testStyleEndpoint(bool $usePathStyle): void
    {
        $client = $this->connection->createS3Client($usePathStyle);

        self::assertSame($usePathStyle, (bool)$client->getConfig('use_path_style_endpoint'));
    }

    public function testCredentials(): void
    {
        /** @var \Aws\Credentials\CredentialsInterface $credentials */
        $credentials = $this->client->getCredentials()->wait();

        self::assertSame('user', $credentials->getAccessKeyId());
        self::assertSame('pass', $credentials->getSecretKey());
    }
}
