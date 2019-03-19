<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Domain;

interface State
{
    public function asArray(): array;
}
