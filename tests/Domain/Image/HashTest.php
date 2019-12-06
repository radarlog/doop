<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Domain\Image;

use Radarlog\Doop\Domain\Image;
use Radarlog\Doop\Tests\UnitTestCase;

class HashTest extends UnitTestCase
{
    public function invalidHashProvider(): \Generator
    {
        yield [''];
        yield [str_repeat('x', 39)];
        yield [str_repeat('x', 41)];
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

        self::assertSame('f32b67c7e26342af42efabc674d441dca0a281c5', (string) $hash);
    }

    public function testValue(): void
    {
        $hash = new Image\Hash('f32b67c7e26342af42efabc674d441dca0a281c5');

        self::assertSame('f32b67c7e26342af42efabc674d441dca0a281c5', (string) $hash);
    }

    public function testLength(): void
    {
        $hash = new Image\Hash('f32b67c7e26342af42efabc674d441dca0a281c5');

        self::assertSame(40, strlen((string) $hash));
    }

    public function testLowerCase(): void
    {
        $hash = new Image\Hash('F32B67C7E26342AF42EFABC674D441DCA0A281C5');

        self::assertSame('f32b67c7e26342af42efabc674d441dca0a281c5', (string) $hash);
    }
}
