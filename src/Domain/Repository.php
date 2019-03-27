<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Domain;

interface Repository
{
    public function add(Aggregate $entity): void;

    public function getById(Identity $id): ?Aggregate;
}
