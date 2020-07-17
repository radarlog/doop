<?php

declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\S3;

use Radarlog\Doop\Infrastructure\Throwable;

class InvalidArgument extends \InvalidArgumentException implements Throwable
{
    // phpcs:disable Generic.CodeAnalysis.UselessOverridingMethod.Found
    final private function __construct(string $message, int $code, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function endpoint(string $url): self
    {
        return new self(sprintf('Invalid endpoint "%s"', $url), self::CODE_S3_ENDPOINT);
    }
}
