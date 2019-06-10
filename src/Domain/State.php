<?php
declare(strict_types=1);

namespace Radarlog\Doop\Domain;

interface State
{
    public function asArray(): array;
}
