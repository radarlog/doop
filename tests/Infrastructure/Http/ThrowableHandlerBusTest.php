<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Infrastructure\Http;

use PHPUnit\Framework\TestCase;
use Radarlog\Doop\Application\Command;
use Radarlog\Doop\Infrastructure\Http\ThrowableHandlerBus;
use Radarlog\Doop\Tests\Application\Command\DummyCommand;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;

final class ThrowableHandlerBusTest extends TestCase
{
    private const ERROR_MESSAGE_TYPE = 'error';

    public function testExecute(): void
    {
        $exception = new \Exception('custom message');

        $innerBus = $this->createMock(Command\Bus::class);
        $innerBus->method('execute')->willThrowException($exception);

        $flashBag = new FlashBag();

        $exceptionHandlerBus = new ThrowableHandlerBus($flashBag, $innerBus);

        $command = new DummyCommand();

        $exceptionHandlerBus->execute($command);

        self::assertTrue($flashBag->has(self::ERROR_MESSAGE_TYPE));

        $messages = $flashBag->get(self::ERROR_MESSAGE_TYPE);

        self::assertCount(1, $messages);
        self::assertSame('custom message', $messages[0]);
    }
}
