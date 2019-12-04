<?php

declare(strict_types=1);

namespace Radarlog\Doop\Domain\Image;

final class File
{
    private Hash $hash;

    private string $content;

    private Format $format;

    /**
     * @noinspection PhpDocMissingThrowsInspection
     * @throws InvalidArgument
     */
    public function __construct(string $content)
    {
        $image = new \Imagick();

        try {
            $image->readImageBlob($content);
        } catch (\ImagickException $e) {
            throw new InvalidArgument('Cannot create image', InvalidArgument::CODE_IMAGE, $e);
        }

        $this->hash = Hash::calculate($content);
        $this->content = $content;
        $this->format = new Format($image);
    }

    public function hash(): Hash
    {
        return $this->hash;
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
