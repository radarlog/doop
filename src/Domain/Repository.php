<?php

declare(strict_types=1);

namespace Radarlog\Doop\Domain;

interface Repository
{
    public function add(Image $image): void;

    public function getByUuid(Image\Uuid $uuid): Image;

    public function remove(Image\Uuid $uuid): void;
}
