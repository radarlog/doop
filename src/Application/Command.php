<?php

declare(strict_types=1);

namespace Radarlog\Doop\Application;

interface Command extends UseCase
{
    /**
     * Fully Qualified Class Name of a corresponding command handler
     */
    public function fqcnHandler(): string;

    /**
     * @return string[]
     */
    public function serialize(): array;
}
