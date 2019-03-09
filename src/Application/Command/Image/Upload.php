<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Application\Command\Image;

use Radarlog\S3Uploader\Application\Command;

final class Upload implements Command
{
    /** @var string */
    private $name;

    /** @var string */
    private $content;

    public function __construct(string $name, string $content)
    {
        $this->name = $name;
        $this->content = $content;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function content(): string
    {
        return $this->content;
    }

    public function fqcnHandler(): string
    {
        return UploadHandler::class;
    }
}
