<?php

declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\Sql;

use Radarlog\Doop\Infrastructure\Throwable;

final class NotFound extends \RuntimeException implements Throwable
{
    // phpcs:disable Generic.CodeAnalysis.UselessOverridingMethod.Found
    private function __construct(string $message, int $code, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function uuid(string $uuid): self
    {
        return new self(sprintf('UUID "%s" not found', $uuid), self::CODE_SQL_NOT_FOUND);
    }
}
