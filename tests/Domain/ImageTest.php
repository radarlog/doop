<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Tests\Domain;

use Radarlog\S3Uploader\Domain\Image;
use Radarlog\S3Uploader\Domain\InvalidArgument;
use Radarlog\S3Uploader\Tests\UnitTestCase;

class ImageTest extends UnitTestCase
{
    /** @var string */
    private $content;

    protected function setUp(): void
    {
        parent::setUp();

        $fixture = $this->fixturePath('Images/avatar.jpg');
        $this->content = file_get_contents($fixture);
    }

    public function testNonPictureType(): void
    {
        $content = __FILE__;

        $this->expectException(InvalidArgument::class);
        $this->expectExceptionCode(InvalidArgument::CODE_IMAGE);

        new Image('name', $content);
    }

    public function testName(): void
    {
        $picture = new Image('some', $this->content);

        self::assertSame('some', $picture->name());
    }

    public function testContent(): void
    {
        $image = new Image('name', $this->content);

        self::assertSame($this->content, $image->content());
    }

    public function testFormat(): void
    {
        $image = new Image('name', $this->content);

        self::assertSame('jpeg', (string)$image->format());
    }
}
