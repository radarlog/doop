<?php

declare(strict_types=1);

namespace Radarlog\Doop\Domain;

interface Repository
{
    public function newUuid(): Image\Uuid;

    public function add(Image $image): void;

    /**
     * @throws Image\NotFound
     */
    public function getByUuid(Image\Uuid $uuid): Image;

    public function remove(Image\Uuid $uuid): void;
}
