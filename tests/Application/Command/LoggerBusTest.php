<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Application\Command;

use Psr\Log\Test\TestLogger;
use Radarlog\Doop\Application\Command;
use Radarlog\Doop\Tests\UnitTestCase;

class LoggerBusTest extends UnitTestCase
{
    public function testExecute(): void
    {
        $innerBus = $this->createMock(Command\Bus::class);

        $logger = new TestLogger();

        $loggerBus = new Command\LoggerBus($logger, $innerBus);

        $command = new DummyCommand();

        $loggerBus->execute($command);

        self::assertFalse($logger->hasErrorRecords());
    }

    public function testExceptionIsLogged(): void
    {
        $exception = Command\RuntimeException::handler(SpyHandler::class);

        $innerBus = $this->createMock(Command\Bus::class);
        $innerBus->method('execute')->willThrowException($exception);

        $command = new DummyCommand();

        $logger = new TestLogger();

        $loggerBus = new Command\LoggerBus($logger, $innerBus);

        $this->expectException($exception::class);

        $loggerBus->execute($command);

        self::assertTrue($logger->hasErrorRecords());
        self::assertTrue($logger->hasError([
            'message' => $exception->getMessage(),
            'context' => [
                DummyCommand::class => $command->serialize(),
                'exception' => $exception,
            ],
        ]));
    }
}
