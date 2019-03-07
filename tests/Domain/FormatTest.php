<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Tests\Domain;

use Radarlog\S3Uploader\Domain\Format;
use Radarlog\S3Uploader\Domain\InvalidArgument;
use Radarlog\S3Uploader\Tests\UnitTestCase;

class FormatTest extends UnitTestCase
{
    public function testCannotReadFormat(): void
    {
        $image = new \Imagick();

        $this->expectException(InvalidArgument::class);
        $this->expectExceptionCode(InvalidArgument::CODE_PICTURE);
        $this->expectExceptionMessage('Cannot read format');

        new Format($image);
    }

    public function testUnsupportedFormat(): void
    {
        $image = new \Imagick($this->fixturePath('Images/avatar.tga'));

        $this->expectException(InvalidArgument::class);
        $this->expectExceptionCode(InvalidArgument::CODE_PICTURE);
        $this->expectExceptionMessage('Unsupported format');

        new Format($image);
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

        self::assertSame($format, strval(new Format($image)));
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

        $format = new Format($image);

        self::assertSame($mime, $format->mime());
    }
}
