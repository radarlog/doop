<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Infrastructure\Sql;

use Radarlog\Doop\Domain\Image;
use Radarlog\Doop\Domain\Repository;
use Radarlog\Doop\Infrastructure\Sql\NotFound;
use Radarlog\Doop\Tests\DbTestCase;

class PersistenceRepositoryTest extends DbTestCase
{
    private const UUID = '572b3706-ffb8-423c-a317-d0ca8016a345';
    private const HASH = '2080492d54a6b8579968901f366b13614fe188f2';
    private const NAME = 'name';

    private Repository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var Repository $repository */
        $repository = self::$container->get(Repository::class);
        $this->repository = $repository;
    }

    public function testAddNew(): void
    {
        $uuid = new Image\Uuid(self::UUID);
        $name = new Image\Name(self::NAME);
        $hash = new Image\Hash(self::HASH);

        $image1 = new Image($uuid, $hash, $name);
        $this->repository->add($image1);

        $image2 = $this->repository->getByUuid($image1->uuid());

        self::assertEquals($image1->uuid(), $image2->uuid());
    }

    public function testGetByNonExistingUuid(): void
    {
        $uuid = new Image\Uuid(self::UUID);

        $this->expectException(NotFound::class);
        $this->expectExceptionCode(3001);

        $this->repository->getByUuid($uuid);
    }

    public function testRemove(): void
    {
        $uuid = new Image\Uuid(self::UUID);
        $name = new Image\Name(self::NAME);
        $hash = new Image\Hash(self::HASH);

        $image = new Image($uuid, $hash, $name);
        $this->repository->add($image);

        $this->repository->remove($image->uuid());

        $this->expectException(NotFound::class);
        $this->expectExceptionCode(3001);

        $this->repository->getByUuid($image->uuid());
    }
}
