<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Domain\Image;

use Radarlog\S3Uploader\Domain;

final class State implements Domain\State
{
    private const KEYS = [
        'uuid',
        'hash',
        'name',
        'uploaded_at',
    ];

    public const DATETIME_FORMAT = 'Y-m-d H:i:s';

    /** @var array */
    private $state;

    public function __construct(array $state)
    {
        if (count(self::KEYS) !== count($state) || array_diff_key($state, array_flip(self::KEYS)) !== []) {
            throw new InvalidArgument('Invalid state provided', InvalidArgument::CODE_STATE);
        }

        $date = \DateTimeImmutable::createFromFormat(self::DATETIME_FORMAT, $state['uploaded_at']);

        if (!($date && $date->format(self::DATETIME_FORMAT) === $state['uploaded_at'])) {
            throw new InvalidArgument('Invalid date format', InvalidArgument::CODE_STATE);
        }

        $this->state = $state;
    }

    public function asArray(): array
    {
        return $this->state;
    }
}
