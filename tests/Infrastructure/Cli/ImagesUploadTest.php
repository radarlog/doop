<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Infrastructure\Cli;

use Radarlog\Doop\Tests\DbTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Tester\CommandTester;

final class ImagesUploadTest extends DbTestCase
{
    private CommandTester $commandTester;

    protected function setUp(): void
    {
        parent::setUp();

        $application = new Application(self::$kernel);
        $command = $application->find('images:upload');

        $this->commandTester = new CommandTester($command);
    }

    public function testExecuteWithNoArguments(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Not enough arguments (missing: "path")');

        $this->commandTester->execute([]);
    }

    public function testExecuteWithWrongPath(): void
    {
        $this->commandTester->execute([
            'path' => ['/path/to/file'],
        ]);

        self::assertStringContainsString('File "/path/to/file" is not readable', $this->commandTester->getDisplay());
    }

    public function testExecuteUpload(): void
    {
        $this->commandTester->execute([
            'path' => [$this->fixturePath('Images/avatar.jpg')],
        ]);

        self::assertStringContainsString('Images/avatar.jpg: Uploaded', $this->commandTester->getDisplay());
    }
}
