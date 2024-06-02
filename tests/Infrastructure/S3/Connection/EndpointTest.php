<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Infrastructure\S3\Connection;

use PHPUnit\Framework\Attributes\DataProvider;
use Radarlog\Doop\Infrastructure\S3\Connection\Endpoint;
use Radarlog\Doop\Infrastructure\S3\InvalidArgument;
use Radarlog\Doop\Tests\UnitTestCase;

final class EndpointTest extends UnitTestCase
{
    /**
     * @return iterable<array<int,string>>
     */
    public static function urlsProvider(): iterable
    {
        yield ['https://host:42'];
        yield ['https://host'];
    }

    #[DataProvider('urlsProvider')]
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
