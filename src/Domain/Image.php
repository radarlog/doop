<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Domain;

final class Image
{
    /** @var string */
    private $name;

    /** @var string */
    private $content;

    /** @var Format */
    private $format;

    /**
     * @noinspection PhpDocMissingThrowsInspection
     * @throws InvalidArgument
     */
    public function __construct(string $name, string $content)
    {
        $image = new \Imagick();

        try {
            $image->readImageBlob($content);
        } catch (\ImagickException $e) {
            throw new InvalidArgument('Cannot create picture', InvalidArgument::CODE_PICTURE, $e);
        }

        $this->name = $name;
        $this->content = $content;
        $this->format = new Format($image);
    }

    public function name(): string
    {
        return $this->name;
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
