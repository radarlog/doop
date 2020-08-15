<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Infrastructure\Http\Controller;

use Radarlog\Doop\Domain;
use Radarlog\Doop\Domain\Image;
use Radarlog\Doop\Infrastructure\Sql;
use Radarlog\Doop\Tests\ControllerTestCase;

class RemoveTest extends ControllerTestCase
{
    private Image\Uuid $uuid;

    private Domain\Repository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $fixture = $this->fixturePath('Images/avatar.jpg');
        $content = (string) file_get_contents($fixture);

        $file = new Image\File($content);

        $uuid = new Image\Uuid('572b3706-ffb8-423c-a317-d0ca8016a345');
        $name = new Image\Name('avatar.jpg');
        $image = new Image($uuid, $file->hash(), $name);

        $this->uuid = $image->uuid();

        /** @var Domain\Storage $storage */
        $storage = self::$container->get(Domain\Storage::class);
        $storage->upload($file);

        /** @var Domain\Repository $repository */
        $repository = self::$container->get(Domain\Repository::class);
        $repository->add($image);

        $this->repository = $repository;
    }

    public function testAction(): void
    {
        $this->client->request('GET', sprintf('/remove/%s', (string) $this->uuid));

        self::assertResponseStatusCodeSame(302);

        $this->expectException(Sql\NotFound::class);
        $this->expectExceptionCode(3001);

        $this->repository->getByUuid($this->uuid);
    }
}
