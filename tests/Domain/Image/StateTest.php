<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Domain\Image;

use Radarlog\Doop\Domain\Image;
use Radarlog\Doop\Tests\UnitTestCase;

final class StateTest extends UnitTestCase
{
    public static function invalidKeysProvider(): \Generator
    {
        yield 'missing all keys' => [['key' => 'value']];
        yield 'redundant key' => [['uuid' => 'u', 'hash' => 'h', 'name' => 'n', 'uploaded_at' => 'd', 'k' => 'v']];
        yield 'missing 1 key' => [['uuid' => 'uuid', 'hash' => 'hash', 'name' => 'name']];
    }

    /**
     * @dataProvider invalidKeysProvider
     */
    public function testInvalidKeysThrowException(array $state): void
    {
        $this->expectException(Image\InvalidArgument::class);
        $this->expectExceptionCode(1002);

        new Image\State($state);
    }

    public function testAsArray(): void
    {
        $origin = [
            'hash' => 'hash',
            'name' => 'name',
            'uploaded_at' => '2019-03-18 23:22:36',
            'uuid' => 'uuid',
        ];

        $state = new Image\State($origin);

        self::assertSame($origin, $state->asArray());
    }
}
