<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Domain\Image;

use PHPUnit\Framework\Attributes\DataProvider;
use Radarlog\Doop\Domain\Image;
use Radarlog\Doop\Tests\UnitTestCase;

final class FormatTest extends UnitTestCase
{
    public function testUnsupportedFormat(): void
    {
        $fixturePath = self::fixturePath('Images/avatar.tga');

        $content = (string) file_get_contents($fixturePath);

        $this->expectException(Image\InvalidArgument::class);
        $this->expectExceptionCode(1006);

        new Image\Format($content);
    }

    /**
     * @return iterable<array{string, string}>
     *
     * @throws \RuntimeException
     */
    public static function mimeProvider(): iterable
    {
        yield [self::fixturePath('Images/avatar.jpg'), 'image/jpeg'];
        yield [self::fixturePath('Images/octopus.png'), 'image/png'];
        yield [self::fixturePath('Images/schedule.svg'), 'image/svg+xml'];
        yield [self::fixturePath('Images/banner.gif'), 'image/gif'];
    }

    #[DataProvider('mimeProvider')]
    public function testMime(string $fixturePath, string $mime): void
    {
        $image = (string) file_get_contents($fixturePath);

        $format = new Image\Format($image);

        self::assertSame($mime, $format->mime());
    }
}
