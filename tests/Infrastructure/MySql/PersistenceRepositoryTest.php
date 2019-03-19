<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Tests\Infrastructure\MySql;

use Radarlog\S3Uploader\Domain\Image;
use Radarlog\S3Uploader\Domain\Repository;
use Radarlog\S3Uploader\Tests\FunctionalTestCase;

class PersistenceRepositoryTest extends FunctionalTestCase
{
    /** @var Repository */
    private $repository;

    /** @var Image\Identity */
    private $uuid;

    protected function setUp(): void
    {
        parent::setUp();

        $this->uuid = Image\Identity::new();
        $this->repository = self::$container->get(Repository::class);
    }

    public function testAddNew(): void
    {
        $image1 = new Image($this->uuid, 'hash', 'name');

        $this->repository->add($image1);

        $image2 = $this->repository->getById($this->uuid);

        self::assertSame($image1->id(), $image2->id());
    }
}
