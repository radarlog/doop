<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Tests\Domain\Data\Meta\Picture;

use Radarlog\S3Uploader\Domain\Image;
use Radarlog\S3Uploader\Domain\InvalidArgument;
use Radarlog\S3Uploader\Tests\UnitTestCase;

class ImageTest extends UnitTestCase
{
    public function testNonPictureType(): void
    {
        $content = __FILE__;

        $this->expectException(InvalidArgument::class);
        $this->expectExceptionCode(InvalidArgument::CODE_PICTURE);

        new Image($content);
    }

    public function testContent(): void
    {
        $fixture = $this->fixturePath('Images/avatar.jpg');
        $content = file_get_contents($fixture);

        $image = new Image($content);

        self::assertSame($content, $image->content());
    }

    public function testFormat(): void
    {
        $fixture = $this->fixturePath('Images/avatar.jpg');
        $content = file_get_contents($fixture);

        $image = new Image($content);

        self::assertSame('jpeg', (string)$image->format());
    }
}
