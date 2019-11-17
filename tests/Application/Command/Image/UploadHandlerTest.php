<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Application\Command\Image;

use Radarlog\Doop\Application\Command;
use Radarlog\Doop\Domain;
use Radarlog\Doop\Tests\UnitTestCase;

class UploadHandlerTest extends UnitTestCase
{
    private string $name = 'some_name';

    private string $hash = '2080492d54a6b8579968901f366b13614fe188f2';

    public function testHandle(): void
    {
        $storage = $this->createMock(Domain\Storage::class);
        $repository = $this->createMock(Domain\Repository::class);

        $storage
            ->expects(self::once())
            ->method('upload')
            ->with(self::callback(function (Domain\Image\File $file) {
                return $this->hash === (string) $file->hash();
            }));

        $repository
            ->expects(self::once())
            ->method('add')
            ->with(self::callback(function (Domain\Image $image) {
                $state = $image->getState()->asArray();

                return $this->hash === $state['hash'] && $this->name === $state['name'];
            }));

        $fixture = $this->fixturePath('Images/avatar.jpg');
        $content = file_get_contents($fixture);

        $command = new Command\Image\Upload($this->name, $content);

        $handler = new Command\Image\UploadHandler($storage, $repository);

        $handler->handle($command);
    }
}
