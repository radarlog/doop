<?php

declare(strict_types=1);

namespace Radarlog\Doop\Application\Command;

use Radarlog\Doop\Application\Throwable;

class RuntimeException extends \RuntimeException implements Throwable
{
    // phpcs:disable Generic.CodeAnalysis.UselessOverridingMethod.Found
    final private function __construct(string $message, int $code, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function handler(string $className): self
    {
        return new self(sprintf('No handler "%s" class found', $className), self::CODE_HANDLER);
    }
}
