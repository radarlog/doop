<?php

declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\Http;

use Radarlog\Doop\Application;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

final class ThrowableHandlerBus implements Application\Command\Bus
{
    readonly private FlashBagInterface $flashBag;

    readonly private Application\Command\Bus $innerBus;

    public function __construct(FlashBagInterface $flashBag, Application\Command\Bus $innerBus)
    {
        $this->flashBag = $flashBag;
        $this->innerBus = $innerBus;
    }

    public function execute(Application\Command $command): void
    {
        try {
            $this->innerBus->execute($command);
        } catch (\Throwable $e) {
            $this->handleThrowable($e);
        }
    }

    private function handleThrowable(\Throwable $e): void
    {
        $this->flashBag->set('error', $e->getMessage());
    }
}
