<?php

declare(strict_types=1);

namespace Radarlog\Doop\Domain\Image;

use Radarlog\Doop\Domain\Throwable;

final class NotFound extends \RuntimeException implements Throwable
{
    // phpcs:disable Generic.CodeAnalysis.UselessOverridingMethod.Found
    private function __construct(string $message, int $code)
    {
        parent::__construct($message, $code);
    }

    public static function uuid(string $uuid): self
    {
        return new self(sprintf('UUID "%s" not found', $uuid), self::CODE_UUID_NOT_FOUND);
    }

    public static function hash(string $hash): self
    {
        return new self(sprintf('Hash "%s" not found', $hash), self::CODE_HASH_NOT_FOUND);
    }
}
