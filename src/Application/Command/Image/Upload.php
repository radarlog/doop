<?php

declare(strict_types=1);

namespace Radarlog\Doop\Application\Command\Image;

use Radarlog\Doop\Application\Command;

final class Upload implements Command
{
    private readonly string $name;

    private readonly string $content;

    public function __construct(string $name, string $content)
    {
        $this->name = $name;
        $this->content = $content;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function content(): string
    {
        return $this->content;
    }

    public function fqcnHandler(): string
    {
        return UploadHandler::class;
    }

    public function serialize(): array
    {
        return get_object_vars($this);
    }
}
