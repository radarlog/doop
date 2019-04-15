<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Infrastructure\Cli;

use Radarlog\S3Uploader\Application\Query;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ImagesList extends Command
{
    /** @var string */
    protected static $defaultName = 'images:list';

    /** @var Query\Image\FindAll */
    private $findAll;

    public function __construct(Query\Image\FindAll $findAll)
    {
        $this->findAll = $findAll;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('List uploaded images');
    }

    // phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $images = $this->findAll->sortedByUploadDate();

        if (count($images) === 0) {
            $output->writeln('No images uploaded');

            return;
        }

        $this->renderImages($images, new Table($output));
    }

    /**
     * @param array&Query\Image\UuidNameDate[] $images
     */
    private function renderImages(array $images, Table $table): void
    {
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
