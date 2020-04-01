<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Infrastructure\S3;

use AsyncAws\Core\Configuration;
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

        $configuration = $connection->configuration();

        self::assertSame(self::REGION, $configuration->get(Configuration::OPTION_REGION));
    }

    public function testEndpoint(): void
    {
        $connection = Connection::from(self::ENDPOINT, self::KEY, self::SECRET, self::REGION);

        $configuration = $connection->configuration();

        self::assertSame(self::ENDPOINT, $configuration->get(Configuration::OPTION_ENDPOINT));
    }

    public function testCredentials(): void
    {
        $connection = Connection::from(self::ENDPOINT, self::KEY, self::SECRET, self::REGION);

        $configuration = $connection->configuration();

        self::assertSame(self::KEY, $configuration->get(Configuration::OPTION_ACCESS_KEY_ID));
        self::assertSame(self::SECRET, $configuration->get(Configuration::OPTION_SECRET_ACCESS_KEY));
    }
}
