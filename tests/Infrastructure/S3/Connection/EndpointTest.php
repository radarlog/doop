<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Infrastructure\S3\Connection;

use Radarlog\Doop\Infrastructure\S3\Connection\Endpoint;
use Radarlog\Doop\Infrastructure\S3\InvalidArgument;
use Radarlog\Doop\Tests\UnitTestCase;

final class EndpointTest extends UnitTestCase
{
    public function urlsProvider(): iterable
    {
        yield ['http://host:42'];
        yield ['http://host'];
    }

    /**
     * @dataProvider urlsProvider
     */
    public function testEndpoint(string $url): void
    {
        $endpoint = new Endpoint($url);

        self::assertSame($url, $endpoint->url());
    }

    public function testExceptionOnInvalidUrl(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionCode(3200);

        new Endpoint('non-url');
    }
}
