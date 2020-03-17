<?php

declare(strict_types=1);

namespace Radarlog\Doop\Domain\Image;

final class Format
{
    private const SUPPORTED = [
        'gif',
        'jpeg',
        'png',
        'svg',
    ];

    private string $format;

    private string $mime;

    /**
     * @throws InvalidArgument
     */
    public function __construct(\Imagick $image)
    {
        try {
            $format = strtolower($image->getImageFormat());
        } catch (\ImagickException $e) {
            throw InvalidArgument::formatRead($e->getMessage(), $e);
        }

        if (!in_array($format, self::SUPPORTED, true)) {
            throw InvalidArgument::formatCreate($format);
        }

        $this->format = $format;
        $this->mime = $image->getImageMimeType();
    }

    public function __toString(): string
    {
        return $this->format;
    }

    public function mime(): string
    {
        return $this->mime;
    }
}
