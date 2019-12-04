<?php

declare(strict_types=1);

namespace Radarlog\Doop\Application\Command;

use Psr\Log\LoggerInterface;
use Radarlog\Doop\Application\Command;

final class LoggerBus implements Bus
{
    private LoggerInterface $logger;

    private Bus $innerBus;

    public function __construct(LoggerInterface $logger, Bus $innerBus)
    {
        $this->logger = $logger;
        $this->innerBus = $innerBus;
    }

    public function execute(Command $command): void
    {
        try {
            $this->innerBus->execute($command);
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage(), [
                'exception' => $e,
                'code' => $e->getCode(),
                get_class($command) => $this->dumpCommandMethods($command),
            ]);

            throw $e;
        }
    }

    /**
     * @return string[]
     */
    private function dumpCommandMethods(Command $command): array
    {
        $methods = [];

        foreach (get_class_methods($command) as $methodName) {
            try {
                $methods[$methodName] = call_user_func([$command, $methodName]);
            } catch (\Throwable $e) {
                $methods[$methodName] = (string) $e;
            }
        }

        return $methods;
    }
}
