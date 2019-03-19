<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Application\Query\Image;

interface FindAll
{
    public function sortedByUploadDate(): array;
}
