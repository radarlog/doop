<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Domain\Image;

final class File
{
    /** @var Hash */
    private $hash;

    /** @var string */
    private $content;

    /** @var Format */
    private $format;

    /**
     * @noinspection PhpDocMissingThrowsInspection
     * @throws InvalidArgument
     */
    public function __construct(Hash $hash, string $content)
    {
        $image = new \Imagick();

        try {
            $image->readImageBlob($content);
        } catch (\ImagickException $e) {
            throw new InvalidArgument('Cannot create image', InvalidArgument::CODE_IMAGE, $e);
        }

        $this->hash = $hash;
        $this->content = $content;
        $this->format = new Format($image);
    }

    public function hash(): string
    {
        return (string)$this->hash;
    }

    public function content(): string
    {
        return $this->content;
    }

    public function format(): Format
    {
        return $this->format;
    }
}
