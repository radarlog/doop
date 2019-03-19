<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Domain;

interface Repository
{
    public function add(Image $image): void;

    public function getById(Image\Identity $id): Image;
}
