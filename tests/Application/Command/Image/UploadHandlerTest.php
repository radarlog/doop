<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Tests\Application\Command\Image;

use Radarlog\S3Uploader\Application\Command;
use Radarlog\S3Uploader\Domain;
use Radarlog\S3Uploader\Tests\UnitTestCase;

class UploadHandlerTest extends UnitTestCase
{
    public function testHandle(): void
    {
        $fixture = $this->fixturePath('Images/avatar.jpg');
        $content = file_get_contents($fixture);

        $command = new Command\Image\Upload('name', $content);

        $storage = $this->createMock(Domain\Storage::class);
        $storage
            ->expects($this->once())
            ->method('upload')
            ->with(self::callback(static function (Domain\Image $image) use ($content) {
                return 'name' === $image->name() && $content === $image->content();
            }));

        $handler = new Command\Image\UploadHandler($storage);

        $handler->handle($command);
    }
}
