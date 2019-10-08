<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Domain\Image;

use Radarlog\Doop\Domain\Image;
use Radarlog\Doop\Tests\UnitTestCase;

class FormatTest extends UnitTestCase
{
    public function testCannotReadFormat(): void
    {
        $image = new \Imagick();

        $this->expectException(Image\InvalidArgument::class);
        $this->expectExceptionCode(Image\InvalidArgument::CODE_IMAGE);
        $this->expectExceptionMessage('Cannot read format');

        new Image\Format($image);
    }

    public function testUnsupportedFormat(): void
    {
        $image = new \Imagick($this->fixturePath('Images/avatar.tga'));

        $this->expectException(Image\InvalidArgument::class);
        $this->expectExceptionCode(Image\InvalidArgument::CODE_IMAGE);
        $this->expectExceptionMessage('Unsupported format');

        new Image\Format($image);
    }

    public function supportedFixturesProvider(): \Generator
    {
        yield [$this->fixturePath('Images/avatar.jpg'), 'jpeg'];
        yield [$this->fixturePath('Images/octopus.png'), 'png'];
    }

    /**
     * @dataProvider supportedFixturesProvider
     */
    public function testSupportedFormat(string $fixturePath, string $format): void
    {
        $image = new \Imagick($fixturePath);

        self::assertSame($format, strval(new Image\Format($image)));
    }

    public function mimeProvider(): \Generator
    {
        yield [$this->fixturePath('Images/avatar.jpg'), 'image/jpeg'];
        yield [$this->fixturePath('Images/octopus.png'), 'image/png'];
    }

    /**
     * @dataProvider mimeProvider
     */
    public function testMime(string $fixturePath, string $mime): void
    {
        $image = new \Imagick($fixturePath);

        $format = new Image\Format($image);

        self::assertSame($mime, $format->mime());
    }
}
