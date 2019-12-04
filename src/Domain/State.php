<?php

declare(strict_types=1);

namespace Radarlog\Doop\Domain;

interface State
{
    /**
     * @return string[]
     */
    public function asArray(): array;
}
