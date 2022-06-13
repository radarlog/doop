<?php

declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\Cli;

use Radarlog\Doop\Application\Query;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ImagesList extends Command implements Executable
{
    /**
     * @var string|null
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     */
    protected static $defaultName = 'images:list';

    readonly private Query $query;

    public function __construct(Query $query)
    {
        $this->query = $query;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('List uploaded images');
    }

    // phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $images = $this->query->findAllSortedByUploadDate();

        $this->renderImages($images, $output);

        return self::SUCCESS;
    }

    /**
     * @param Query\UuidNameDate[] $images
     *
     * @throws InvalidArgumentException
     */
    private function renderImages(array $images, OutputInterface $output): void
    {
        if ($images === []) {
            $output->writeln('No images uploaded');

            return;
        }

        $table = new Table($output);

        foreach ($images as $image) {
            $table->addRow([$image->uuid(), $image->name(), $image->uploadedAt()]);
        }

        $table
            ->setHeaderTitle(sprintf('Images (%d)', count($images)))
            ->setHeaders(['UUID', 'Name', 'Uploaded Date'])
            ->setColumnWidths([36, 50, 19])
            ->setStyle('box')
            ->render();
    }
}
