<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Infrastructure\Http\Controller;

use Radarlog\Doop\Domain;
use Radarlog\Doop\Domain\Image;
use Radarlog\Doop\Infrastructure\Sql;
use Radarlog\Doop\Tests\ControllerTestCase;

final class RemoveTest extends ControllerTestCase
{
    private const UUID = '572b3706-ffb8-423c-a317-d0ca8016a345';

    readonly private Image\Uuid $uuid;

    readonly private Domain\Repository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $fixture = $this->fixturePath('Images/avatar.jpg');
        $content = (string) file_get_contents($fixture);

        $file = new Image\File($content);

        $this->uuid = new Image\Uuid(self::UUID);

        $name = new Image\Name('avatar.jpg');
        $image = new Image($this->uuid, $file->hash(), $name);

        /** @var Domain\Storage $storage */
        $storage = self::getContainer()->get(Domain\Storage::class);
        $storage->upload($file);

        /** @var Domain\Repository $repository */
        $repository = self::getContainer()->get(Domain\Repository::class);
        $repository->add($image);

        $this->repository = $repository;
    }

    public function testAction(): void
    {
        $this->client->request('GET', sprintf('/remove/%s', self::UUID));

        self::assertResponseStatusCodeSame(302);

        $this->expectException(Sql\NotFound::class);
        $this->expectExceptionCode(3001);

        $this->repository->getByUuid($this->uuid);
    }
}
