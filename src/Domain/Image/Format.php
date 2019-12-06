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
            throw new InvalidArgument($e->getMessage(), InvalidArgument::CODE_FORMAT_READ, $e);
        }

        if (!in_array($format, self::SUPPORTED, true)) {
            throw new InvalidArgument('Unsupported format', InvalidArgument::CODE_FORMAT_CREATE);
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
