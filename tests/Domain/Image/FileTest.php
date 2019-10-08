<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Domain\Image;

use Radarlog\Doop\Domain\Image;
use Radarlog\Doop\Tests\UnitTestCase;

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

        new Image\File($content);
    }

    public function testName(): void
    {
        $file = new Image\File($this->content);

        self::assertSame('2080492d54a6b8579968901f366b13614fe188f2', (string) $file->hash());
    }

    public function testContent(): void
    {
        $file = new Image\File($this->content);

        self::assertSame($this->content, $file->content());
    }

    public function testFormat(): void
    {
        $file = new Image\File($this->content);

        self::assertSame('jpeg', (string) $file->format());
    }
}
