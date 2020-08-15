<?php

declare(strict_types=1);

namespace Radarlog\Doop\Application;

interface Query
{
    /**
     * @return Query\UuidNameDate[]
     */
    public function findAllSortedByUploadDate(): array;

    public function findOneHashNameByUuid(string $uuid): Query\HashName;

    public function countHashesByUuid(string $uuid): Query\HashCount;
}
