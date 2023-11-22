<?php

declare(strict_types=1);

namespace Radarlog\Doop\Application\Command;

use Radarlog\Doop\Application\Throwable;

final class NotFound extends \RuntimeException implements Throwable
{
    // phpcs:disable Generic.CodeAnalysis.UselessOverridingMethod.Found
    private function __construct(string $message, int $code)
    {
        parent::__construct($message, $code);
    }

    public static function handler(string $className): self
    {
        return new self(sprintf('No handler "%s" class found', $className), self::CODE_HANDLER);
    }
}
