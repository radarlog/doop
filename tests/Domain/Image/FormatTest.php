<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Domain\Image;

use Radarlog\Doop\Domain\Image;
use Radarlog\Doop\Tests\UnitTestCase;

class FormatTest extends UnitTestCase
{
    public function testUnsupportedFormat(): void
    {
        $fixturePath = $this->fixturePath('Images/avatar.tga');

        $content = (string) file_get_contents($fixturePath);

        $this->expectException(Image\InvalidArgument::class);
        $this->expectExceptionCode(1006);

        new Image\Format($content);
    }

    public function mimeProvider(): \Generator
    {
        yield [$this->fixturePath('Images/avatar.jpg'), 'image/jpeg'];
        yield [$this->fixturePath('Images/octopus.png'), 'image/png'];
        yield [$this->fixturePath('Images/schedule.svg'), 'image/svg+xml'];
        yield [$this->fixturePath('Images/banner.gif'), 'image/gif'];
    }

    /**
     * @dataProvider mimeProvider
     */
    public function testMime(string $fixturePath, string $mime): void
    {
        $image = (string) file_get_contents($fixturePath);

        $format = new Image\Format($image);

        self::assertSame($mime, $format->mime());
    }
}
