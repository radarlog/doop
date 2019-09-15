<?php
declare(strict_types=1);

namespace Radarlog\Doop\Tests\Infrastructure\S3\Connection;

use Radarlog\Doop\Infrastructure\S3\Connection\Key;
use Radarlog\Doop\Tests\UnitTestCase;

class KeyTest extends UnitTestCase
{
    public function validKeysProvider(): iterable
    {
        yield ['secRET'];
        yield ['sec/RET'];
        yield ['sec+RET'];
        yield ['sec%2FRET'];
    }

    /**
     * @dataProvider validKeysProvider
     */
    public function testName(string $key): void
    {
        $cred = new Key($key);

        self::assertSame($key, $cred->decoded());
    }
}
