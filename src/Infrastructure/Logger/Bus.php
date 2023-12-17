<?php

declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\Logger;

use Psr\Log\LoggerInterface;
use Radarlog\Doop\Application\Command;

final readonly class Bus implements Command\Bus
{
    private LoggerInterface $logger;

    private Command\Bus $innerBus;

    public function __construct(LoggerInterface $logger, Command\Bus $innerBus)
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
