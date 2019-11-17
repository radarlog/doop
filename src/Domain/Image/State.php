<?php

declare(strict_types=1);

namespace Radarlog\Doop\Domain\Image;

use Radarlog\Doop\Domain;

final class State implements Domain\State
{
    private const EXPECTED_KEYS = [
        'uuid',
        'hash',
        'name',
        'uploaded_at',
    ];

    /** @var string[] */
    private array $state = [];

    public function __construct(array $state)
    {
        $expected = array_flip(self::EXPECTED_KEYS);

        // check whether all keys are exactly the same
        if (array_diff_key($state, $expected) !== array_diff_key($expected, $state)) {
            throw new InvalidArgument('Invalid state provided', InvalidArgument::CODE_STATE);
        }

        $this->state = $state;
    }

    public function asArray(): array
    {
        return $this->state;
    }
}
