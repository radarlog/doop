<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Application\Command\Image;

use Radarlog\Doop\Application\Command;
use Radarlog\Doop\Tests\UnitTestCase;

final class RemoveTest extends UnitTestCase
{
    private const UUID = '572b3706-ffb8-423c-a317-d0ca8016a345';

    private Command\Image\Remove $command;

    protected function setUp(): void
    {
        parent::setUp();

        $this->command = new Command\Image\Remove(self::UUID);
    }

    public function testId(): void
    {
        self::assertSame(self::UUID, $this->command->uuid());
    }

    public function testFqcnHandler(): void
    {
        self::assertSame(Command\Image\RemoveHandler::class, $this->command->fqcnHandler());
    }

    public function testSerialize(): void
    {
        $dump = $this->command->serialize();

        self::assertCount(1, $dump);

        self::assertArrayHasKey('uuid', $dump);

        self::assertSame(self::UUID, $dump['uuid']);
    }
}
