<?php
declare(strict_types=1);

namespace Radarlog\Doop\Domain\Image;

use Radarlog\Doop\Domain;
use Ramsey\Uuid;

final class Identity implements Domain\Identity
{
    private const UUID_PATTERN = '/[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[0-9a-f]{4}-[0-9a-f]{12}/';

    /** @var string */
    private $uuid;

    /**
     * @throws InvalidArgument
     */
    public function __construct(?string $uuid = null)
    {
        $uuid = $uuid ?? $this->new();

        if (preg_match(self::UUID_PATTERN, $uuid) !== 1) {
            throw new InvalidArgument('Invalid UUID', InvalidArgument::CODE_UUID);
        }

        $this->uuid = $uuid;
    }

    public function toString(): string
    {
        return $this->uuid;
    }

    private function new(): string
    {
        return Uuid\Uuid::uuid4()->toString();
    }
}
