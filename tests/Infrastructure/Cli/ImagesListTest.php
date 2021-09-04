<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Infrastructure\Cli;

use Radarlog\Doop\Domain\Image;
use Radarlog\Doop\Domain\Repository;
use Radarlog\Doop\Tests\DbTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class ImagesListTest extends DbTestCase
{
    private const UUID = '572b3706-ffb8-423c-a317-d0ca8016a345';
    private const HASH = '2080492d54a6b8579968901f366b13614fe188f2';
    private const NAME = 'name';
    private const DATE = '2019-03-18 23:22:36';

    private Repository $repository;

    private CommandTester $commandTester;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var Repository $repository */
        $repository = self::getContainer()->get(Repository::class);
        $this->repository = $repository;

        $application = new Application(self::$kernel);
        $command = $application->find('images:list');

        $this->commandTester = new CommandTester($command);
    }

    public function testExecuteWithNoImages(): void
    {
        $this->commandTester->execute([]);

        self::assertStringContainsString('No images uploaded', $this->commandTester->getDisplay());
    }

    public function testExecuteWithUploadedImages(): void
    {
        $state = new Image\State([
            'uuid' => self::UUID,
            'hash' => self::HASH,
            'name' => self::NAME,
            'uploaded_at' => self::DATE,
        ]);
        $image = Image::fromState($state);
        $this->repository->add($image);

        $this->commandTester->execute([]);

        $output = $this->commandTester->getDisplay();

        self::assertStringContainsString('Images (1)', $output);

        self::assertStringContainsString('UUID', $output);
        self::assertStringContainsString('Name', $output);
        self::assertStringContainsString('Uploaded Date', $output);

        self::assertStringContainsString(self::UUID, $output);
        self::assertStringContainsString(self::NAME, $output);
        self::assertStringContainsString(self::DATE, $output);
    }
}
