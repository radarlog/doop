<?php

declare(strict_types=1);

namespace Radarlog\Doop\Application;

interface Command
{
    /**
     * Fully Qualified Class Name of a corresponding command handler
     */
    public function fqcnHandler(): string;
}
