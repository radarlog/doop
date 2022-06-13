<?php

declare(strict_types=1);

namespace Radarlog\Doop\Application\Command;

use Psr\Log\LoggerInterface;
use Radarlog\Doop\Application\Command;

final class LoggerBus implements Bus
{
    readonly private LoggerInterface $logger;

    readonly private Bus $innerBus;

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
                $command::class => $command->serialize(),
                'exception' => $e,
            ]);

            throw $e;
        }
    }
}
