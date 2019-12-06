<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Application\Command\Image;

use Radarlog\Doop\Application\Command;
use Radarlog\Doop\Tests\UnitTestCase;

class UploadTest extends UnitTestCase
{
    private Command\Image\Upload $command;

    protected function setUp(): void
    {
        parent::setUp();

        $this->command = new Command\Image\Upload('some_name', 'some_content');
    }

    public function testName(): void
    {
        self::assertSame('some_name', $this->command->name());
    }

    public function testContent(): void
    {
        self::assertSame('some_content', $this->command->content());
    }

    public function testFqcnHandler(): void
    {
        self::assertSame(Command\Image\UploadHandler::class, $this->command->fqcnHandler());
    }

    public function testSerialize(): void
    {
        $dump = $this->command->serialize();

        self::assertCount(2, $dump);

        self::assertArrayHasKey('name', $dump);
        self::assertArrayHasKey('content', $dump);

        self::assertSame('some_name', $dump['name']);
        self::assertSame('some_content', $dump['content']);
    }
}
