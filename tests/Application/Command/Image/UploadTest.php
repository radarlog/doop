<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Application\Command\Image;

use Radarlog\Doop\Application\Command;
use Radarlog\Doop\Tests\UnitTestCase;

final class UploadTest extends UnitTestCase
{
    private const NAME = 'name';
    private const CONTENT = 'content';

    readonly private Command\Image\Upload $command;

    protected function setUp(): void
    {
        parent::setUp();

        $this->command = new Command\Image\Upload(self::NAME, self::CONTENT);
    }

    public function testName(): void
    {
        self::assertSame(self::NAME, $this->command->name());
    }

    public function testContent(): void
    {
        self::assertSame(self::CONTENT, $this->command->content());
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

        self::assertSame(self::NAME, $dump['name']);
        self::assertSame(self::CONTENT, $dump['content']);
    }
}
