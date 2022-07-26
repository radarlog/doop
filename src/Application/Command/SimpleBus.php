<?php

declare(strict_types=1);

namespace Radarlog\Doop\Application\Command;

use Radarlog\Doop\Application\Command;

final class SimpleBus implements Bus
{
    /** @var Handler[] */
    private array $handlers = [];

    /**
     * @param Handler[] $handlers
     */
    public function __construct(iterable $handlers)
    {
        foreach ($handlers as $handler) {
            $this->add($handler);
        }
    }

    private function add(Handler $handler): void
    {
        $this->handlers[$handler::class] = $handler;
    }

    /**
     * @throws NotFound
     */
    private function resolver(Command $command): Handler
    {
        $handlerClass = $command->fqcnHandler();

        if (!array_key_exists($handlerClass, $this->handlers)) {
            throw NotFound::handler($handlerClass);
        }

        return $this->handlers[$handlerClass];
    }

    public function execute(Command $command): void
    {
        $handler = $this->resolver($command);

        $handler->handle($command);
    }
}
