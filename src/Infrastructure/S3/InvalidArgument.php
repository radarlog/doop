<?php

declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\S3;

use Radarlog\Doop\Infrastructure\Throwable;

final class InvalidArgument extends \InvalidArgumentException implements Throwable
{
    // phpcs:disable Generic.CodeAnalysis.UselessOverridingMethod.Found
    private function __construct(string $message, int $code)
    {
        parent::__construct($message, $code);
    }

    public static function endpoint(string $url): self
    {
        return new self(sprintf('Invalid endpoint "%s"', $url), self::CODE_S3_ENDPOINT);
    }
}
