<?php

declare(strict_types=1);

namespace Radarlog\Doop\Application;

use Radarlog\Doop\Domain\Image;

interface Query extends UseCase
{
    /**
     * @return Query\UuidNameDate[]
     */
    public function findAllSortedByUploadDate(): array;

    /**
     * @throws Image\NotFound
     */
    public function findOneHashNameByUuid(string $uuid): Query\HashName;

    /**
     * @throws Image\NotFound
     */
    public function countHashesByUuid(string $uuid): Query\HashCount;
}
