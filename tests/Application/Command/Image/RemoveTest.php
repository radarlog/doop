<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Application\Command\Image;

use Radarlog\Doop\Application\Command;
use Radarlog\Doop\Tests\UnitTestCase;

class RemoveTest extends UnitTestCase
{
    private Command\Image\Remove $command;

    protected function setUp(): void
    {
        parent::setUp();

        $this->command = new Command\Image\Remove('some_id');
    }

    public function testId(): void
    {
        self::assertSame('some_id', $this->command->id());
    }

    public function testFqcnHandler(): void
    {
        self::assertSame(Command\Image\RemoveHandler::class, $this->command->fqcnHandler());
    }

    public function testSerialize(): void
    {
        $dump = $this->command->serialize();

        self::assertCount(1, $dump);

        self::assertArrayHasKey('id', $dump);

        self::assertSame('some_id', $dump['id']);
    }
}
