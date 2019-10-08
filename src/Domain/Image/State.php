<?php

declare(strict_types=1);

namespace Radarlog\Doop\Domain\Image;

use Radarlog\Doop\Domain;

final class State implements Domain\State
{
    private const KEYS = [
        'uuid',
        'hash',
        'name',
        'uploaded_at',
    ];

    /** @var array */
    private $state;

    public function __construct(array $state)
    {
        if (count(self::KEYS) !== count($state) || array_diff_key($state, array_flip(self::KEYS)) !== []) {
            throw new InvalidArgument('Invalid state provided', InvalidArgument::CODE_STATE);
        }

        $this->state = $state;
    }

    public function asArray(): array
    {
        return $this->state;
    }
}
