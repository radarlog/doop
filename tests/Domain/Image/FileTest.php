<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Domain\Image;

use Radarlog\Doop\Domain\Image;
use Radarlog\Doop\Tests\UnitTestCase;

final class FileTest extends UnitTestCase
{
    private const string HASH = '2080492d54a6b8579968901f366b13614fe188f2';

    private Image\File $file;

    private string $content;

    protected function setUp(): void
    {
        parent::setUp();

        $fixture = self::fixturePath('Images/avatar.jpg');
        $content = (string) file_get_contents($fixture);

        $this->file = new Image\File($content);

        $this->content = $content;
    }

    public function testName(): void
    {
        self::assertSame(self::HASH, (string) $this->file->hash());
    }

    public function testContent(): void
    {
        self::assertSame($this->content, $this->file->content());
    }

    public function testFormat(): void
    {
        $format = new Image\Format($this->content);

        self::assertEquals($format, $this->file->format());
    }
}
