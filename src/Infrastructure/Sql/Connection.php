<?php

declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\Sql;

use Doctrine\DBAL\Connections\PrimaryReadReplicaConnection;

final class Connection extends PrimaryReadReplicaConnection
{
    private const string IMAGES_TABLE = 'images';

    public function imagesTable(): string
    {
        return $this->quoteIdentifier(self::IMAGES_TABLE);
    }
}
