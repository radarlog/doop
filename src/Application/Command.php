<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Application;

interface Command
{
    /**
     * Fully Qualified Class Name of a corresponding command handler
     */
    public function fqcnHandler(): string;
}
