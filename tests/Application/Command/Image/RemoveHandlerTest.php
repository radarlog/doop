<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Application\Command\Image;

use PHPUnit\Framework\MockObject\MockObject;
use Radarlog\Doop\Application\Command;
use Radarlog\Doop\Application\Query;
use Radarlog\Doop\Domain;
use Radarlog\Doop\Tests\UnitTestCase;

class RemoveHandlerTest extends UnitTestCase
{
    private const UUID = '572b3706-ffb8-423c-a317-d0ca8016a345';

    private const HASH = '2080492d54a6b8579968901f366b13614fe188f2';

    /** @var MockObject&Domain\Storage */
    private Domain\Storage $storage;

    /** @var MockObject&Query */
    private Query $query;

    private Command\Image\RemoveHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->storage = $this->createMock(Domain\Storage::class);
        $this->query = $this->createMock(Query::class);

        $repository = $this->createMock(Domain\Repository::class);
        $repository
            ->expects(self::once())
            ->method('remove')
            ->with(self::callback(static fn(Domain\Image\Identity $identity) => (string) $identity === self::UUID));

        $this->handler = new Command\Image\RemoveHandler($this->storage, $repository, $this->query);
    }

    public function testHandleOneHash(): void
    {
        $this->query
            ->expects(self::once())
            ->method('countHashesById')
            ->willReturn(new Query\HashCount(self::HASH, 1));

        $this->storage
            ->expects(self::once())
            ->method('delete')
            ->with(self::callback(static fn(Domain\Image\Hash $hash) => (string) $hash === self::HASH));

        $command = new Command\Image\Remove(self::UUID);

        $this->handler->handle($command);
    }

    public function testHandleMoreThanOneHash(): void
    {
        $this->query
            ->expects(self::once())
            ->method('countHashesById')
            ->willReturn(new Query\HashCount(self::HASH, 3));

        $this->storage
            ->expects(self::never())
            ->method('delete');

        $command = new Command\Image\Remove(self::UUID);

        $this->handler->handle($command);
    }
}
