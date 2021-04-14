<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Application\Command;

use Radarlog\Doop\Application\Command;
use Radarlog\Doop\Tests\UnitTestCase;

class SimpleBusTest extends UnitTestCase
{
    public function testNoHandler(): void
    {
        $handler = $this->createMock(Command\Handler::class);

        $bus = new Command\SimpleBus([$handler]);

        $command = $this->createMock(Command::class);

        $this->expectException(Command\RuntimeException::class);
        $this->expectExceptionCode(2000);

        $bus->execute($command);
    }

    public function testExecute(): void
    {
        $handler = new SpyHandler();

        $bus = new Command\SimpleBus([$handler]);

        /** @var Command $command */
        $command = $this->createConfiguredMock(Command::class, [
            'fqcnHandler' => $handler::class,
        ]);

        $bus->execute($command);

        self::assertSame($command, $handler->command());
    }
}
