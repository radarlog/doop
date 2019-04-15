<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Application\Query\Image;

interface FindAll
{
    /**
     * @return array&UuidNameDate[]
     */
    public function sortedByUploadDate(): array;
}
