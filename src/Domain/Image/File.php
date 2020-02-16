<?php

declare(strict_types=1);

namespace Radarlog\Doop\Domain\Image;

final class File
{
    private Hash $hash;

    private string $content;

    private Format $format;

    /**
     * @throws InvalidArgument
     */
    public function __construct(string $content)
    {
        $this->hash = Hash::calculate($content);
        $this->content = $content;
        $this->format = new Format($content);
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
