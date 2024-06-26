<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Infrastructure\Sql;

use Radarlog\Doop\Domain\Image;
use Radarlog\Doop\Domain\Repository;
use Radarlog\Doop\Tests\DbTestCase;
use Symfony\Component\Uid\Uuid;

final class PersistenceRepositoryTest extends DbTestCase
{
    private const string UUID = '572b3706-ffb8-723c-a317-d0ca8016a345';
    private const string HASH = '2080492d54a6b8579968901f366b13614fe188f2';
    private const string NAME = 'name';

    private Repository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = self::getContainer()->get(Repository::class);
    }

    public function testUuidGenerator(): void
    {
        $uuid = $this->repository->newUuid();

        self::assertTrue(Uuid::isValid((string) $uuid));
    }

    public function testAddNew(): void
    {
        $uuid = new Image\Uuid(self::UUID);
        $name = new Image\Name(self::NAME);
        $hash = new Image\Hash(self::HASH);

        $image1 = Image::new($uuid, $hash, $name);
        $this->repository->add($image1);

        $image2 = $this->repository->getByUuid($image1->uuid());

        self::assertEquals($image1->uuid(), $image2->uuid());
    }

    public function testGetByNonExistingUuid(): void
    {
        $uuid = new Image\Uuid(self::UUID);

        $this->expectException(Image\NotFound::class);
        $this->expectExceptionCode(1007);

        $this->repository->getByUuid($uuid);
    }

    public function testRemove(): void
    {
        $uuid = new Image\Uuid(self::UUID);
        $name = new Image\Name(self::NAME);
        $hash = new Image\Hash(self::HASH);

        $image = Image::new($uuid, $hash, $name);
        $this->repository->add($image);

        $this->repository->remove($image->uuid());

        $this->expectException(Image\NotFound::class);
        $this->expectExceptionCode(1007);

        $this->repository->getByUuid($image->uuid());
    }
}
