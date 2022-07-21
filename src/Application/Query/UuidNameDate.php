<?php

declare(strict_types=1);

namespace Radarlog\Doop\Application\Query;

final class UuidNameDate
{
    private readonly string $uuid;

    private readonly string $name;

    private readonly string $uploadedAt;

    public function __construct(string $uuid, string $name, string $uploadedAt)
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->uploadedAt = $uploadedAt;
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function uploadedAt(): string
    {
        return $this->uploadedAt;
    }
}
