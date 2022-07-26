<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Infrastructure\Logger;

use Monolog;
use Psr\Log\LoggerInterface;
use Radarlog\Doop\Application\Command;
use Radarlog\Doop\Infrastructure\Logger;
use Radarlog\Doop\Tests\Application\Command\DummyCommand;
use Radarlog\Doop\Tests\Application\Command\SpyHandler;
use Radarlog\Doop\Tests\UnitTestCase;

final class BusTest extends UnitTestCase
{
    private LoggerInterface $logger;

    private Monolog\Handler\TestHandler $testHandler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->testHandler = new Monolog\Handler\TestHandler();

        $this->logger = new Monolog\Logger('test', [
            $this->testHandler,
        ]);
    }

    public function testExecute(): void
    {
        $innerBus = $this->createMock(Command\Bus::class);

        $loggerBus = new Logger\Bus($this->logger, $innerBus);

        $command = new DummyCommand();

        $loggerBus->execute($command);

        self::assertFalse($this->testHandler->hasErrorRecords());
    }

    public function testExceptionIsLogged(): void
    {
        $exception = Command\NotFound::handler(SpyHandler::class);

        $innerBus = $this->createMock(Command\Bus::class);
        $innerBus->method('execute')->willThrowException($exception);

        $command = new DummyCommand();

        $loggerBus = new Logger\Bus($this->logger, $innerBus);

        $this->expectException($exception::class);

        $loggerBus->execute($command);

        self::assertTrue($this->testHandler->hasErrorRecords());
        self::assertTrue($this->testHandler->hasError([
            'message' => $exception->getMessage(),
            'context' => [
                DummyCommand::class => $command->serialize(),
                'exception' => $exception,
            ],
        ]));
    }
}
