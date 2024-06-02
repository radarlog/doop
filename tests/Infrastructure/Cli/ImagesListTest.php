<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Infrastructure\Cli;

use Radarlog\Doop\Domain\Image;
use Radarlog\Doop\Domain\Repository;
use Radarlog\Doop\Tests\DbTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\HttpKernel\KernelInterface;

final class ImagesListTest extends DbTestCase
{
    private const string UUID = '572b3706-ffb8-723c-a317-d0ca8016a345';
    private const string HASH = '2080492d54a6b8579968901f366b13614fe188f2';
    private const string NAME = 'name';
    private const string DATE = '2019-03-18 23:22:36';

    private Repository $repository;

    private CommandTester $commandTester;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = self::getContainer()->get(Repository::class);

        assert(self::$kernel instanceof KernelInterface);
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
            'hash' => self::HASH,
            'name' => self::NAME,
            'uploaded_at' => self::DATE,
            'uuid' => self::UUID,
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
