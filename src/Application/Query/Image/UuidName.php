<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Application\Query\Image;

final class UuidName
{
    /** @var string */
    private $uuid;

    /** @var string */
    private $name;

    public function __construct(string $uuid, string $name)
    {
        $this->uuid = $uuid;
        $this->name = $name;
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function name(): string
    {
        return $this->name;
    }
}
