<?php

declare(strict_types=1);

namespace Radarlog\Doop\Application;

interface Query
{
    /**
     * @return Query\UuidNameDate[]
     */
    public function findAllSortedByUploadDate(): array;

    public function findOneHashNameById(string $id): Query\HashName;

    public function countHashesById(string $id): Query\HashCount;
}
