<?php

declare(strict_types=1);

namespace Radarlog\Doop\Application\Command;

use Radarlog\Doop\Application\Command;

final class SimpleBus implements Bus
{
    /** @var Handler[] */
    private array $handlers;

    public function __construct(iterable $handlers)
    {
        foreach ($handlers as $handler) {
            $this->add($handler);
        }
    }

    private function add(Handler $handler): void
    {
        $this->handlers[get_class($handler)] = $handler;
    }

    /**
     * @throws RuntimeException
     */
    private function resolver(Command $command): Handler
    {
        $handlerClass = $command->fqcnHandler();

        if (!array_key_exists($handlerClass, $this->handlers)) {
            throw new RuntimeException('No handler', RuntimeException::CODE_HANDLER);
        }

        return $this->handlers[$handlerClass];
    }

    public function execute(Command $command): void
    {
        $handler = $this->resolver($command);

        $handler->handle($command);
    }
}
