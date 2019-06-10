<?php
declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\Cli;

use Radarlog\Doop\Application\Command;
use Symfony\Component\Console;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ImagesUpload extends Console\Command\Command
{
    /** @var string */
    protected static $defaultName = 'images:upload';

    /** @var Command\Bus */
    private $bus;

    /** @var string[] */
    private $paths = [];

    public function __construct(Command\Bus $bus)
    {
        $this->bus = $bus;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Uploaded new images')
            ->addArgument('path', InputArgument::IS_ARRAY | InputArgument::REQUIRED, 'Images path');
    }

    // phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter
    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->paths = array_unique($input->getArgument('path'));
    }

    // phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        foreach ($this->paths as $path) {
            try {
                $this->uploadFile($path);

                $output->writeln(sprintf('%s: <info>Uploaded</info>', $path));
            } catch (\Throwable $e) {
                $output->writeln(sprintf('%s: <error>%s</error>', $path, $e->getMessage()));
            }
        }
    }

    private function uploadFile(string $path): void
    {
        $fileInfo = new \SplFileInfo($path);

        $name = $fileInfo->getBasename();
        $content = $this->loadFileContent($fileInfo);

        $command = new Command\Image\Upload($name, $content);

        $this->bus->execute($command);
    }

    private function loadFileContent(\SplFileInfo $fileInfo): string
    {
        if ($fileInfo->isFile() && $fileInfo->isReadable()) {
            $file = $fileInfo->openFile();

            return (string)$file->fread($file->getSize());
        }

        throw new InvalidArgument('File is not readable', InvalidArgument::CODE_READ_FILE);
    }
}
