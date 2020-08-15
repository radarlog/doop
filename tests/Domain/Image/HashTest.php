<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Domain\Image;

use Radarlog\Doop\Domain\Image;
use Radarlog\Doop\Tests\UnitTestCase;

class HashTest extends UnitTestCase
{
    private const HASH = 'f32b67c7e26342af42efabc674d441dca0a281c5';

    public function invalidHashProvider(): \Generator
    {
        yield [''];
        yield [str_repeat('a', 39)];
        yield [str_repeat('b', 41)];
        yield [str_repeat('x', 40)];
    }

    /**
     * @dataProvider invalidHashProvider
     */
    public function testInvalidHash(string $value): void
    {
        $this->expectException(Image\InvalidArgument::class);
        $this->expectExceptionCode(1004);

        new Image\Hash($value);
    }

    public function testCalculate(): void
    {
        $hash = Image\Hash::calculate('value');

        self::assertSame(self::HASH, (string) $hash);
    }

    public function testValue(): void
    {
        $hash = new Image\Hash(self::HASH);

        self::assertSame(self::HASH, (string) $hash);
    }

    public function testLength(): void
    {
        $hash = new Image\Hash(self::HASH);

        self::assertSame(40, strlen((string) $hash));
    }

    public function testLowerCase(): void
    {
        $hash = new Image\Hash('F32B67C7E26342AF42EFABC674D441DCA0A281C5');

        self::assertSame(self::HASH, (string) $hash);
    }
}
