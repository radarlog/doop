<?php

declare(strict_types=1);

namespace Radarlog\Doop\Application\Command\Image;

use Radarlog\Doop\Application\Command;

final class Remove implements Command
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function fqcnHandler(): string
    {
        return 'RemoveHandler::class';
    }

    public function serialize(): array
    {
        return get_object_vars($this);
    }
}
