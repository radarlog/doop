<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Tests\Domain\Image;

use Radarlog\S3Uploader\Domain\Image;
use Radarlog\S3Uploader\Tests\UnitTestCase;

class FileTest extends UnitTestCase
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

        $this->expectException(Image\InvalidArgument::class);
        $this->expectExceptionCode(Image\InvalidArgument::CODE_IMAGE);

        new Image\File('name', $content);
    }

    public function testName(): void
    {
        $file = new Image\File('some', $this->content);

        self::assertSame('some', $file->name());
    }

    public function testContent(): void
    {
        $file = new Image\File('name', $this->content);

        self::assertSame($this->content, $file->content());
    }

    public function testFormat(): void
    {
        $file = new Image\File('name', $this->content);

        self::assertSame('jpeg', (string)$file->format());
    }
}
