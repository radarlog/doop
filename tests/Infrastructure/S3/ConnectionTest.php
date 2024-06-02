<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Infrastructure\S3;

use AsyncAws\Core\Configuration;
use Radarlog\Doop\Infrastructure\S3\Connection;
use Radarlog\Doop\Infrastructure\S3\InvalidArgument;
use Radarlog\Doop\Tests\UnitTestCase;

final class ConnectionTest extends UnitTestCase
{
    private const string ENDPOINT = 'https://host:42';
    private const string KEY = 'key';
    private const string SECRET = 'secret';
    private const string REGION = 'region';

    private const string DSN = 'https://key:secret@host:42/region';

    private Connection $connection;

    protected function setUp(): void
    {
        parent::setUp();

        $this->connection = Connection::from(self::ENDPOINT, self::KEY, self::SECRET, self::REGION);
    }

    public function testFrom(): void
    {
        $endpoint = new Connection\Endpoint(self::ENDPOINT);
        $key = new Connection\Key(self::KEY);
        $secret = new Connection\Key(self::SECRET);
        $region = new Connection\Region(self::REGION);

        $connection = new Connection($endpoint, $key, $secret, $region);

        self::assertEquals($connection, $this->connection);
    }

    public function testFromDsn(): void
    {
        $connection = Connection::fromDsn(self::DSN);

        self::assertEquals($connection, $this->connection);
    }

    public function testExceptionFromDsn(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionCode(3200);

        Connection::fromDsn('non-url');
    }

    public function testRegion(): void
    {
        $configuration = $this->connection->configuration();

        self::assertSame(self::REGION, $configuration->get(Configuration::OPTION_REGION));
    }

    public function testEndpoint(): void
    {
        $configuration = $this->connection->configuration();

        self::assertSame(self::ENDPOINT, $configuration->get(Configuration::OPTION_ENDPOINT));
    }

    public function testCredentials(): void
    {
        $configuration = $this->connection->configuration();

        self::assertSame(self::KEY, $configuration->get(Configuration::OPTION_ACCESS_KEY_ID));
        self::assertSame(self::SECRET, $configuration->get(Configuration::OPTION_SECRET_ACCESS_KEY));
    }
}
