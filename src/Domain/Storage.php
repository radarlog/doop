<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Domain;

interface Storage
{
    public function upload(Image\File $file): void;

    public function list(): \Iterator;

    public function get(string $name): Image\File;
}
