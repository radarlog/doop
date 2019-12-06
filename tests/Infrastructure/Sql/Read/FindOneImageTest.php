<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Infrastructure\Sql\Read;

use Radarlog\Doop\Application\Query;
use Radarlog\Doop\Domain\Image;
use Radarlog\Doop\Domain\Repository;
use Radarlog\Doop\Infrastructure\Sql;
use Radarlog\Doop\Tests\DbTestCase;

class FindOneImageTest extends DbTestCase
{
    private Query\Image\FindOne $query;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var Repository $repository */
        $repository = self::$container->get('test.repository');

        $state1 = new Image\State([
            'uuid' => '9f2149bb-b6e5-4ae0-a188-e616cddc8e98',
            'hash' => '2346ad27d7568ba9896f1b7da6b5991251debdf2',
            'name' => 'name1',
            'uploaded_at' => '2018-01-01 23:22:36',
        ]);
        $image1 = Image::fromState($state1);
        $repository->add($image1);

        $state2 = new Image\State([
            'uuid' => '572b3706-ffb8-423c-a317-d0ca8016a345',
            'hash' => 'f32b67c7e26342af42efabc674d441dca0a281c5',
            'name' => 'name2',
            'uploaded_at' => '2018-03-18 23:22:36',
        ]);
        $image2 = Image::fromState($state2);
        $repository->add($image2);

        $this->query = self::$container->get('test.query.one');
    }

    public function testNameByHash(): void
    {
        $result = $this->query->hashNameByUuid('572b3706-ffb8-423c-a317-d0ca8016a345');

        self::assertSame('f32b67c7e26342af42efabc674d441dca0a281c5', $result->hash());
        self::assertSame('name2', $result->name());
    }

    public function testNameByHashNotFound(): void
    {
        $this->expectException(Sql\NotFound::class);
        $this->expectExceptionCode(3001);

        $this->query->hashNameByUuid('384a2c67-4d6d-41a9-9954-b5bf75de708e');
    }
}
