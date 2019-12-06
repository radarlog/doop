<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Application\Command;

use Radarlog\Doop\Application\Command;

final class DummyCommand implements Command
{
    public function fqcnHandler(): string
    {
        return SpyHandler::class;
    }

    public function serialize(): array
    {
        return ['bar'];
    }
}
