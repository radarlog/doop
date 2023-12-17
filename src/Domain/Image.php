<?php

declare(strict_types=1);

namespace Radarlog\Doop\Domain;

final class Image
{
    private const string DATETIME_FORMAT = 'Y-m-d H:i:s';

    private readonly Image\Uuid $uuid;

    private readonly Image\Name $name;

    private readonly Image\Hash $hash;

    private readonly \DateTimeImmutable $uploadedAt;

    private function __construct(Image\Uuid $uuid, Image\Hash $hash, Image\Name $name, \DateTimeImmutable $uploadedAt)
    {
        $this->uuid = $uuid;
        $this->hash = $hash;
        $this->name = $name;
        $this->uploadedAt = $uploadedAt;
    }

    public function uuid(): Image\Uuid
    {
        return $this->uuid;
    }

    public function getState(): Image\State
    {
        return new Image\State([
            'hash' => (string) $this->hash,
            'name' => (string) $this->name,
            'uploaded_at' => $this->uploadedAt->format(self::DATETIME_FORMAT),
            'uuid' => (string) $this->uuid,
        ]);
    }

    public static function new(Image\Uuid $uuid, Image\Hash $hash, Image\Name $name): self
    {
        $uploadedAt = new \DateTimeImmutable();

        return new self($uuid, $hash, $name, $uploadedAt);
    }

    public static function fromState(Image\State $state): self
    {
        $state = $state->asArray();

        $uuid = new Image\Uuid($state['uuid']);
        $hash = new Image\Hash($state['hash']);
        $name = new Image\Name($state['name']);
        $uploadedAt = self::hydrateDate($state['uploaded_at']);

        return new self($uuid, $hash, $name, $uploadedAt);
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
