<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Domain;

final class Image implements Aggregate
{
    /** @var Image\Identity */
    private $id;

    /** @var Image\Name */
    private $name;

    /** @var Image\Hash */
    private $hash;

    /** @var \DateTimeImmutable */
    private $uploadedAt;

    public function __construct(Image\Identity $id, Image\Hash $hash, Image\Name $name)
    {
        $this->id = $id;
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
            'hash' => (string)$this->hash,
            'name' => (string)$this->name,
            'uploaded_at' => $this->uploadedAt->format(Image\State::DATETIME_FORMAT),
        ]);
    }

    public static function fromState(State $state): Aggregate
    {
        $state = $state->asArray();

        $id = new Image\Identity($state['uuid']);
        $hash = new Image\Hash($state['hash']);
        $name = new Image\Name($state['name']);

        $image = new self($id, $hash, $name);

        $image->uploadedAt = new \DateTimeImmutable($state['uploaded_at']);

        return $image;
    }
}
