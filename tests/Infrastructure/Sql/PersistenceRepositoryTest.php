<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Infrastructure\Sql;

use Radarlog\Doop\Domain\Image;
use Radarlog\Doop\Domain\Repository;
use Radarlog\Doop\Infrastructure\Sql\NotFound;
use Radarlog\Doop\Tests\DbTestCase;

class PersistenceRepositoryTest extends DbTestCase
{
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
        $name = new Image\Name('name');
        $hash = new Image\Hash('f32b67c7e26342af42efabc674d441dca0a281c5');

        $image1 = new Image($hash, $name);
        $this->repository->add($image1);

        $image2 = $this->repository->getById($image1->id());

        self::assertEquals($image1->id(), $image2->id());
    }

    public function testGetByNonExistingId(): void
    {
        $identity = new Image\Identity('572b3706-ffb8-423c-a317-d0ca8016a345');

        $this->expectException(NotFound::class);
        $this->expectExceptionCode(3001);

        $this->repository->getById($identity);
    }
}
