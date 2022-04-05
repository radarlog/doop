<?php

declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\S3;

use Radarlog\Doop\Infrastructure\Throwable;

final class NotFound extends \RuntimeException implements Throwable
{
    // phpcs:disable Generic.CodeAnalysis.UselessOverridingMethod.Found
    private function __construct(string $message, int $code, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function hash(string $hash): self
    {
        return new self(sprintf('Hash "%s" not found', $hash), self::CODE_S3_NOT_FOUND);
    }
}
