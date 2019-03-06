<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Domain;

interface Storage
{
    public function upload(Image $image): void;
}
