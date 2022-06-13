<?php

declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\Cli;

use Radarlog\Doop\Application\Command;
use Symfony\Component\Console;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class RemoveImage extends Console\Command\Command implements Executable
{
    /**
     * @var string|null
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     */
    protected static $defaultName = 'images:remove';

    readonly private Command\Bus $bus;

    private string $uuid = '';

    public function __construct(Command\Bus $bus)
    {
        $this->bus = $bus;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Remove image')
            ->addArgument('uuid', InputArgument::REQUIRED, 'Image UUID');
    }

    // phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter
    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $uuid = $input->getArgument('uuid');

        $this->uuid = $uuid;
    }

    // phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $command = new Command\Image\Remove($this->uuid);

        $this->bus->execute($command);

        $output->writeln('Image removed');

        return self::SUCCESS;
    }
}
