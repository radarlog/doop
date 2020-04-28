<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Infrastructure\Http\Controller;

use Radarlog\Doop\Domain;
use Radarlog\Doop\Domain\Image;
use Radarlog\Doop\Infrastructure\Sql;
use Radarlog\Doop\Tests\ControllerTestCase;

class RemoveTest extends ControllerTestCase
{
    private Image\Identity $uuid;

    private Domain\Repository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $fixture = $this->fixturePath('Images/avatar.jpg');
        $content = (string) file_get_contents($fixture);

        $file = new Image\File($content);

        $name = new Image\Name('avatar.jpg');
        $image = new Image($file->hash(), $name);

        $this->uuid = $image->id();

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
        $this->client->request('GET', sprintf('/remove/%s', $this->uuid->toString()));

        self::assertResponseStatusCodeSame(302);

        $this->expectException(Sql\NotFound::class);
        $this->expectExceptionCode(3001);

        $this->repository->getById($this->uuid);
    }
}
