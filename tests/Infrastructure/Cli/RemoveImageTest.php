<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Infrastructure\Cli;

use Radarlog\Doop\Domain\Image;
use Radarlog\Doop\Domain\Repository;
use Radarlog\Doop\Tests\DbTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class RemoveImageTest extends DbTestCase
{
    private Repository $repository;

    private CommandTester $commandTester;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var Repository $repository */
        $repository = self::$container->get(Repository::class);
        $this->repository = $repository;

        $application = new Application(self::$kernel);
        $command = $application->find('images:remove');

        $this->commandTester = new CommandTester($command);
    }

    public function testExecute(): void
    {
        $state = new Image\State([
            'uuid' => '572b3706-ffb8-423c-a317-d0ca8016a345',
            'hash' => 'f32b67c7e26342af42efabc674d441dca0a281c5',
            'name' => 'unique_name',
            'uploaded_at' => '2018-03-18 23:22:36',
        ]);
        $image = Image::fromState($state);
        $this->repository->add($image);

        $this->commandTester->execute([
            'uuid' => '572b3706-ffb8-423c-a317-d0ca8016a345',
        ]);

        $output = $this->commandTester->getDisplay();

        self::assertStringContainsString('Image removed', $output);
    }
}
