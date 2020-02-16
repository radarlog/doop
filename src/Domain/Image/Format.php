<?php

declare(strict_types=1);

namespace Radarlog\Doop\Domain\Image;

final class Format
{
    private const SUPPORTED_MIME_TYPES = [
        'image/gif',
        'image/jpeg',
        'image/png',
        'image/svg+xml',
    ];

    private string $mime;

    /**
     * @throws InvalidArgument
     */
    public function __construct(string $content)
    {
        $fileInfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime = (string) $fileInfo->buffer($content);

        if (!in_array($mime, self::SUPPORTED_MIME_TYPES, true)) {
            throw InvalidArgument::formatCreate($mime);
        }

        $this->mime = $mime;
    }

    public function mime(): string
    {
        return $this->mime;
    }
}
