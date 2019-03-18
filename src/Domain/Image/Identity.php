<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Domain\Image;

use Ramsey\Uuid;

final class Identity
{
    /** @var Uuid\UuidInterface */
    private $uuid;

    /**
     * @throws InvalidArgument
     */
    public function __construct(string $uuid)
    {
        try {
            $this->uuid = Uuid\Uuid::fromString($uuid);
        } catch (\Throwable $e) {
            throw new InvalidArgument('Invalid UUID', InvalidArgument::CODE_UUID);
        }
    }

    public function toString(): string
    {
        return $this->uuid->toString();
    }

    public static function new(): Identity
    {
        $uuid = Uuid\Uuid::uuid4();

        return new self($uuid->toString());
    }
}
