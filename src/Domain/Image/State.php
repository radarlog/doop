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
    private readonly array $state;

    /**
     * @param string[] $state
     *
     * @throws InvalidArgument
     */
    public function __construct(array $state)
    {
        /** @var string[] $expected */
        $expected = array_combine(self::EXPECTED_KEYS, self::EXPECTED_KEYS);

        // check whether all keys are exactly the same
        if (array_diff_key($state, $expected) !== array_diff_key($expected, $state)) {
            throw InvalidArgument::state();
        }

        $this->state = $state;
    }

    /**
     * @return string[]
     */
    public function asArray(): array
    {
        return $this->state;
    }
}
