<?php

declare(strict_types=1);

namespace Radarlog\Doop\Domain;

final class Image implements Aggregate
{
    private const DATETIME_FORMAT = 'Y-m-d H:i:s';

    private Image\Identity $id;

    private Image\Name $name;

    private Image\Hash $hash;

    private \DateTimeImmutable $uploadedAt;

    public function __construct(Image\Hash $hash, Image\Name $name)
    {
        $this->id = Image\Identity::new();
        $this->hash = $hash;
        $this->name = $name;
        $this->uploadedAt = new \DateTimeImmutable();
    }

    public function id(): Identity
    {
        return $this->id;
    }

    public function getState(): State
    {
        return new Image\State([
            'uuid' => $this->id->toString(),
            'hash' => (string) $this->hash,
            'name' => (string) $this->name,
            'uploaded_at' => $this->uploadedAt->format(self::DATETIME_FORMAT),
        ]);
    }

    public static function fromState(State $state): Aggregate
    {
        $state = $state->asArray();

        $hash = new Image\Hash($state['hash']);
        $name = new Image\Name($state['name']);

        $image = new self($hash, $name);

        $image->id = new Image\Identity($state['uuid']);
        $image->uploadedAt = self::hydrateDate($state['uploaded_at']);

        return $image;
    }

    private static function hydrateDate(string $uploadedAt): \DateTimeImmutable
    {
        $date = \DateTimeImmutable::createFromFormat(self::DATETIME_FORMAT, $uploadedAt);

        if ($date && $date->format(self::DATETIME_FORMAT) === $uploadedAt) {
            return $date;
        }

        throw Image\InvalidArgument::date($uploadedAt);
    }
}
