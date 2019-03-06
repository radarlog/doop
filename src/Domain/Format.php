<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Domain;

final class Format
{
    private const SUPPORTED = [
        'gif',
        'jpeg',
        'png',
    ];

    /** @var string */
    private $format;

    /**
     * @throws InvalidArgument
     */
    public function __construct(\Imagick $image)
    {
        try {
            $format = strtolower($image->getImageFormat());
        } catch (\ImagickException $e) {
            throw new InvalidArgument('Cannot read format', InvalidArgument::CODE_PICTURE, $e);
        }

        if (!in_array($format, self::SUPPORTED)) {
            throw new InvalidArgument('Unsupported format', InvalidArgument::CODE_PICTURE);
        }

        $this->format = $format;
    }

    public function __toString(): string
    {
        return $this->format;
    }
}
