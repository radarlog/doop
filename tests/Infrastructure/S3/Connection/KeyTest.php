<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Infrastructure\S3\Connection;

use PHPUnit\Framework\Attributes\DataProvider;
use Radarlog\Doop\Infrastructure\S3\Connection\Key;
use Radarlog\Doop\Tests\UnitTestCase;

final class KeyTest extends UnitTestCase
{
    /**
     * @return iterable<array<int,string>>
     */
    public static function validKeysProvider(): iterable
    {
        yield ['secRET'];
        yield ['sec/RET'];
        yield ['sec+RET'];
        yield ['sec%2FRET'];
    }

    #[DataProvider('validKeysProvider')]
    public function testName(string $key): void
    {
        $cred = new Key($key);

        self::assertSame($key, $cred->decoded());
    }
}
