<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Infrastructure\Http\Controller;

use Radarlog\Doop\Domain;
use Radarlog\Doop\Domain\Image;
use Radarlog\Doop\Tests\ControllerTestCase;

final class RemoveTest extends ControllerTestCase
{
    private const UUID = '572b3706-ffb8-723c-a317-d0ca8016a345';

    private Image\Uuid $uuid;

    private Domain\Repository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $fixture = self::fixturePath('Images/avatar.jpg');
        $content = (string) file_get_contents($fixture);

        $file = new Image\File($content);

        $this->uuid = new Image\Uuid(self::UUID);

        $name = new Image\Name('avatar.jpg');
        $image = Image::new($this->uuid, $file->hash(), $name);

        $storage = self::getContainer()->get(Domain\Storage::class);
        $storage->upload($file);

        $repository = self::getContainer()->get(Domain\Repository::class);
        $repository->add($image);

        $this->repository = $repository;
    }

    public function testAction(): void
    {
        $this->client->request('GET', sprintf('/remove/%s', self::UUID));

        self::assertResponseStatusCodeSame(302);

        $this->expectException(Image\NotFound::class);
        $this->expectExceptionCode(1007);

        $this->repository->getByUuid($this->uuid);
    }
}
