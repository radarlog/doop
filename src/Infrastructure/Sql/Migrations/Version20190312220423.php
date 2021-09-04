<?php

declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\Sql\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;
use Radarlog\Doop\Infrastructure\Sql;

// phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter
final class Version20190312220423 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create images table';
    }

    public function up(Schema $schema): void
    {
        /** @var Sql\Connection $connection */
        $connection = $this->connection;

        $table = $schema->createTable($connection->imagesTable());

        $table->addColumn('uuid', Types::GUID, ['notnull' => true]);
        $table->addColumn('hash', Types::STRING, ['notnull' => true, 'length' => 40]);
        $table->addColumn('name', Types::STRING, ['notnull' => true, 'length' => 255]);
        $table->addColumn('uploaded_at', Types::DATETIME_IMMUTABLE, ['notnull' => true]);

        $table->setPrimaryKey(['uuid']);
    }

    public function down(Schema $schema): void
    {
        /** @var Sql\Connection $connection */
        $connection = $this->connection;

        $schema->dropTable($connection->imagesTable());
    }
}
