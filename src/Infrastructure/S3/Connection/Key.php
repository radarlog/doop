<?php

declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\S3\Connection;

final class Key
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $this->encode($id);
    }

    private function encode(string $id): string
    {
        $encoded = urlencode($id);

        if ($id !== $encoded) {
            $id = $encoded;
        }

        return $id;
    }

    public function decoded(): string
    {
        return urldecode($this->id);
    }
}
