<?php

declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\S3\Connection;

/**
 * @link https://docs.aws.amazon.com/general/latest/gr/rande.html#s3_region
 */
final readonly class Region
{
    private string $region;

    public function __construct(string $name)
    {
        $this->region = $name;
    }

    public function name(): string
    {
        return $this->region;
    }
}
