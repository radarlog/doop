<?php

declare(strict_types=1);

namespace Radarlog\Doop\Domain;

interface Repository
{
    public function add(Image $image): void;

    public function getById(Image\Identity $id): Image;

    public function remove(Image\Identity $id): void;
}
