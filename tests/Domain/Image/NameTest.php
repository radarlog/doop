<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Domain\Image;

use Radarlog\Doop\Domain\Image;
use Radarlog\Doop\Tests\UnitTestCase;

final class NameTest extends UnitTestCase
{
    public static function invalidLengthProvider(): \Generator
    {
        yield [''];
        yield ["\t\n"];
        yield ['                       '];
        yield ['ab'];
        yield [str_repeat('x', 256)];
    }

    /**
     * @dataProvider invalidLengthProvider
     */
    public function testInvalidLength(string $origin): void
    {
        $this->expectException(Image\InvalidArgument::class);
        $this->expectExceptionCode(1003);

        new Image\Name($origin);
    }

    public function testStringify(): void
    {
        $name = new Image\Name('name');

        self::assertSame('name', (string) $name);
    }
}
