<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Infrastructure\Sql;

use Radarlog\Doop\Application\Query;
use Radarlog\Doop\Domain\Image;
use Radarlog\Doop\Domain\Repository;
use Radarlog\Doop\Tests\DbTestCase;

final class ReadModelTest extends DbTestCase
{
    private const UUID1 = '9f2149bb-b6e5-7ae0-a188-e616cddc8e98';
    private const UUID2 = '572b3706-ffb8-723c-a317-d0ca8016a345';

    private const NAME1 = 'name1';
    private const NAME2 = 'name2';

    private const DATE1 = '2019-03-18 23:22:36';
    private const DATE2 = '2019-03-18 23:22:37';

    private const HASH = '2080492d54a6b8579968901f366b13614fe188f2';

    private const MISSING_UUID = '384a2c67-4d6d-41a9-9954-b5bf75de708e';

    private Query $query;

    protected function setUp(): void
    {
        parent::setUp();

        $repository = self::getContainer()->get(Repository::class);

        $state1 = new Image\State([
            'uuid' => self::UUID1,
            'hash' => self::HASH,
            'name' => self::NAME1,
            'uploaded_at' => self::DATE1,
        ]);
        $image1 = Image::fromState($state1);
        $repository->add($image1);

        $state2 = new Image\State([
            'uuid' => self::UUID2,
            'hash' => self::HASH,
            'name' => self::NAME2,
            'uploaded_at' => self::DATE2,
        ]);
        $image2 = Image::fromState($state2);
        $repository->add($image2);

        $query = self::getContainer()->get(Query::class);
        $this->query = $query;
    }

    public function testSortedByUploadDate(): void
    {
        $result = $this->query->findAllSortedByUploadDate();

        $expected = [
            new Query\UuidNameDate(self::UUID2, self::NAME2, self::DATE2),
            new Query\UuidNameDate(self::UUID1, self::NAME1, self::DATE1),
        ];

        self::assertCount(2, $result);
        self::assertEquals($expected, $result);
    }

    public function testHashesById(): void
    {
        $hashCount = new Query\HashCount(self::HASH, 2);

        self::assertEquals($hashCount, $this->query->countHashesByUuid(self::UUID1));
    }

    public function testHashesNotFound(): void
    {
        $this->expectException(Image\NotFound::class);
        $this->expectExceptionCode(1007);

        $this->query->countHashesByUuid(self::MISSING_UUID);
    }

    public function testNameByHash(): void
    {
        $result = $this->query->findOneHashNameByUuid(self::UUID1);

        self::assertSame(self::HASH, (string) $result->hash());
        self::assertSame(self::NAME1, (string) $result->name());
    }

    public function testNameByHashNotFound(): void
    {
        $this->expectException(Image\NotFound::class);
        $this->expectExceptionCode(1007);

        $this->query->findOneHashNameByUuid(self::MISSING_UUID);
    }
}
