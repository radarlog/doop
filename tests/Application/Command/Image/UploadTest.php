<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Tests\Application\Command\Image;

use Radarlog\S3Uploader\Application\Command;
use Radarlog\S3Uploader\Tests\UnitTestCase;

class UploadTest extends UnitTestCase
{
    /** @var Command\Image\Upload */
    private $command;

    protected function setUp(): void
    {
        parent::setUp();

        $this->command = new Command\Image\Upload('name', 'content');
    }

    public function testName(): void
    {
        self::assertSame('name', $this->command->name());
    }

    public function testContent(): void
    {
        self::assertSame('content', $this->command->content());
    }

    public function testFqcnHandler(): void
    {
        self::assertSame(Command\Image\UploadHandler::class, $this->command->fqcnHandler());
    }
}
