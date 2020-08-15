<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Infrastructure\Sql;

use Radarlog\Doop\Application\Query;
use Radarlog\Doop\Domain\Image;
use Radarlog\Doop\Domain\Repository;
use Radarlog\Doop\Infrastructure\Sql;
use Radarlog\Doop\Tests\DbTestCase;

class ReadModelTest extends DbTestCase
{
    private const HASH = '2346ad27d7568ba9896f1b7da6b5991251debdf2';

    private Query $query;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var Repository $repository */
        $repository = self::$container->get(Repository::class);

        $state1 = new Image\State([
            'uuid' => '9f2149bb-b6e5-4ae0-a188-e616cddc8e98',
            'hash' => self::HASH,
            'name' => 'name1',
            'uploaded_at' => '2018-01-01 23:22:36',
        ]);
        $image1 = Image::fromState($state1);
        $repository->add($image1);

        $state2 = new Image\State([
            'uuid' => '572b3706-ffb8-423c-a317-d0ca8016a345',
            'hash' => self::HASH,
            'name' => 'name2',
            'uploaded_at' => '2018-03-18 23:22:36',
        ]);
        $image2 = Image::fromState($state2);
        $repository->add($image2);

        /** @var Query $query */
        $query = self::$container->get(Query::class);
        $this->query = $query;
    }

    public function testSortedByUploadDate(): void
    {
        $result = $this->query->findAllSortedByUploadDate();

        $expected = [
            new Query\UuidNameDate('572b3706-ffb8-423c-a317-d0ca8016a345', 'name2', '2018-03-18 23:22:36'),
            new Query\UuidNameDate('9f2149bb-b6e5-4ae0-a188-e616cddc8e98', 'name1', '2018-01-01 23:22:36'),
        ];

        self::assertCount(2, $result);
        self::assertEquals($expected, $result);
    }

    public function testHashesById(): void
    {
        $hashCount = new Query\HashCount(self::HASH, 2);

        self::assertEquals($hashCount, $this->query->countHashesByUuid('9f2149bb-b6e5-4ae0-a188-e616cddc8e98'));
    }

    public function testHashesNotFound(): void
    {
        $this->expectException(Sql\NotFound::class);
        $this->expectExceptionCode(3001);

        $this->query->countHashesByUuid('384a2c67-4d6d-41a9-9954-b5bf75de708e');
    }

    public function testNameByHash(): void
    {
        $result = $this->query->findOneHashNameByUuid('9f2149bb-b6e5-4ae0-a188-e616cddc8e98');

        self::assertSame(self::HASH, (string) $result->hash());
        self::assertSame('name1', (string) $result->name());
    }

    public function testNameByHashNotFound(): void
    {
        $this->expectException(Sql\NotFound::class);
        $this->expectExceptionCode(3001);

        $this->query->findOneHashNameByUuid('384a2c67-4d6d-41a9-9954-b5bf75de708e');
    }
}
