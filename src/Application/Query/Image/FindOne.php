<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Application\Query\Image;

interface FindOne
{
    public function hashNameByUuid(string $uuid): ?array;
}
