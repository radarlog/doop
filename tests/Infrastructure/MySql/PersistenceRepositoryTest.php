<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Tests\Infrastructure\MySql;

use Radarlog\S3Uploader\Domain\Image;
use Radarlog\S3Uploader\Domain\Repository;
use Radarlog\S3Uploader\Tests\DbTestCase;

class PersistenceRepositoryTest extends DbTestCase
{
    /** @var Repository */
    private $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = self::$container->get(Repository::class);
    }

    public function testAddNew(): void
    {
        $name = new Image\Name('name');
        $hash = new Image\Hash('f32b67c7e26342af42efabc674d441dca0a281c5');

        $image1 = new Image($hash, $name);
        $this->repository->add($image1);

        $id = $image1->id();

        $image2 = $this->repository->getById($id);

        self::assertSame($id->toString(), $image2->id()->toString());
    }
}
