<?php

declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\Cli;

use Radarlog\Doop\Infrastructure\Throwable;

class InvalidArgument extends \InvalidArgumentException implements Throwable
{
    // phpcs:disable Generic.CodeAnalysis.UselessOverridingMethod.Found
    final private function __construct(string $message, int $code, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function file(string $path): self
    {
        return new self(sprintf('File "%s" is not readable', $path), self::CODE_CLI_FILE_READ);
    }
}
