<?php

declare(strict_types=1);

namespace Radarlog\Doop\Domain;

interface Storage
{
    public function upload(Image\File $file): void;

    /**
     * @throws Image\NotFound
     */
    public function download(Image\Hash $hash): Image\File;

    public function delete(Image\Hash $hash): void;
}
