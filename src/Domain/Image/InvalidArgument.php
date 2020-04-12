<?php

declare(strict_types=1);

namespace Radarlog\Doop\Domain\Image;

use Radarlog\Doop\Domain\Throwable;

class InvalidArgument extends \InvalidArgumentException implements Throwable
{
    // phpcs:disable Generic.CodeAnalysis.UselessOverridingMethod.Found
    final private function __construct(string $message = '', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function uuid(string $uuid): self
    {
        return new self(sprintf('UUID "%s" is invalid', $uuid), self::CODE_UUID);
    }

    public static function state(): self
    {
        return new self('Invalid state provided', self::CODE_STATE);
    }

    public static function name(string $name): self
    {
        return new self(sprintf('Name "%s" is invalid', $name), self::CODE_NAME);
    }

    public static function hash(string $hash): self
    {
        return new self(sprintf('Hash "%s" is invalid', $hash), self::CODE_HASH);
    }

    public static function date(string $date): self
    {
        return new self(sprintf('Date format "%s" is invalid', $date), self::CODE_DATE);
    }

    public static function formatCreate(string $format): self
    {
        return new self(sprintf('Format "%s" is unsupported', $format), self::CODE_MIME_TYPE);
    }
}
