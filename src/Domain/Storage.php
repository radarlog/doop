<?php
declare(strict_types=1);

namespace Radarlog\Doop\Domain;

interface Storage
{
    public function upload(Image\File $file): void;

    public function get(string $hash): Image\File;
}
