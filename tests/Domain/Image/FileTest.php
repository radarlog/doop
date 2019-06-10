<?php
declare(strict_types=1);

namespace Radarlog\Doop\Tests\Domain\Image;

use Radarlog\Doop\Domain\Image;
use Radarlog\Doop\Tests\UnitTestCase;

class FileTest extends UnitTestCase
{
    /** @var string */
    private $content;

    /** @var Image\Hash */
    private $hash;

    protected function setUp(): void
    {
        parent::setUp();

        $fixture = $this->fixturePath('Images/avatar.jpg');
        $this->content = file_get_contents($fixture);

        $this->hash = new Image\Hash('f32b67c7e26342af42efabc674d441dca0a281c5');
    }

    public function testNonPictureType(): void
    {
        $content = __FILE__;

        $this->expectException(Image\InvalidArgument::class);
        $this->expectExceptionCode(Image\InvalidArgument::CODE_IMAGE);

        new Image\File($this->hash, $content);
    }

    public function testName(): void
    {
        $file = new Image\File($this->hash, $this->content);

        self::assertSame((string)$this->hash, $file->hash());
    }

    public function testContent(): void
    {
        $file = new Image\File($this->hash, $this->content);

        self::assertSame($this->content, $file->content());
    }

    public function testFormat(): void
    {
        $file = new Image\File($this->hash, $this->content);

        self::assertSame('jpeg', (string)$file->format());
    }
}
