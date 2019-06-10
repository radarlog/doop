<?php
declare(strict_types=1);

namespace Radarlog\Doop\Application\Query\Image;

interface FindAll
{
    /**
     * @return array&UuidNameDate[]
     */
    public function sortedByUploadDate(): array;
}
