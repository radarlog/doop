<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Application\Command\Image;

use PHPUnit\Framework\MockObject\MockObject;
use Radarlog\Doop\Application\Command;
use Radarlog\Doop\Application\Query;
use Radarlog\Doop\Domain;
use Radarlog\Doop\Tests\UnitTestCase;

final class DeleteHandlerTest extends UnitTestCase
{
    private const string UUID = '572b3706-ffb8-723c-a317-d0ca8016a345';
    private const string HASH = '2080492d54a6b8579968901f366b13614fe188f2';

    private MockObject & Domain\Storage $storage;

    private MockObject & Query $query;

    private Command\Image\DeleteHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->storage = $this->createMock(Domain\Storage::class);
        $this->query = $this->createMock(Query::class);

        $repository = $this->createMock(Domain\Repository::class);
        $repository
            ->expects(self::once())
            ->method('remove')
            ->with(self::callback(static fn(Domain\Image\Uuid $uuid) => (string) $uuid === self::UUID));

        $this->handler = new Command\Image\DeleteHandler($this->storage, $repository, $this->query);
    }

    public function testHandleOneHash(): void
    {
        $this->query
            ->expects(self::once())
            ->method('countHashesByUuid')
            ->willReturn(new Query\HashCount(self::HASH, 1));

        $this->storage
            ->expects(self::once())
            ->method('delete')
            ->with(self::callback(static fn(Domain\Image\Hash $hash) => (string) $hash === self::HASH));

        $command = new Command\Image\Delete(self::UUID);

        $this->handler->handle($command);
    }

    public function testHandleMoreThanOneHash(): void
    {
        $this->query
            ->expects(self::once())
            ->method('countHashesByUuid')
            ->willReturn(new Query\HashCount(self::HASH, 3));

        $this->storage
            ->expects(self::never())
            ->method('delete');

        $command = new Command\Image\Delete(self::UUID);

        $this->handler->handle($command);
    }
}
