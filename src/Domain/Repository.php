<?php

declare(strict_types=1);

namespace Radarlog\Doop\Domain;

interface Repository
{
    public function add(Aggregate $entity): void;

    public function getById(Identity $id): Aggregate;
}
