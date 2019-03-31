<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Infrastructure\MySql;

use Doctrine\DBAL\Connections\MasterSlaveConnection;

final class Connection extends MasterSlaveConnection
{
    private const IMAGES_TABLE = 'images';

    public function imagesTable(): string
    {
        return $this->quoteIdentifier(self::IMAGES_TABLE);
    }
}
