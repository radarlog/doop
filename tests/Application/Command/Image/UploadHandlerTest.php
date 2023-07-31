<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Application\Command\Image;

use Radarlog\Doop\Application\Command;
use Radarlog\Doop\Domain;
use Radarlog\Doop\Tests\UnitTestCase;

final class UploadHandlerTest extends UnitTestCase
{
    private const UUID = '572b3706-ffb8-723c-a317-d0ca8016a345';
    private const HASH = '2080492d54a6b8579968901f366b13614fe188f2';
    private const NAME = 'name';

    public function testHandle(): void
    {
        $storage = $this->createMock(Domain\Storage::class);
        $repository = $this->createConfiguredMock(Domain\Repository::class, [
            'newUuid' => new Domain\Image\Uuid(self::UUID),
        ]);

        $storage
            ->expects(self::once())
            ->method('upload')
            ->with(self::callback(
                static fn(Domain\Image\File $file): bool => (string) $file->hash() === self::HASH,
            ));

        $repository
            ->expects(self::once())
            ->method('add')
            ->with(self::callback(static function (Domain\Image $image) {
                $state = $image->getState()->asArray();

                return $state['hash'] === self::HASH && $state['name'] === self::NAME;
            }));

        $fixture = self::fixturePath('Images/avatar.jpg');
        $content = (string) file_get_contents($fixture);

        $command = new Command\Image\Upload(self::NAME, $content);

        $handler = new Command\Image\UploadHandler($storage, $repository);

        $handler->handle($command);
    }
}
