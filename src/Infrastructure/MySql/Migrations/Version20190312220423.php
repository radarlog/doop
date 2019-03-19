<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Infrastructure\MySql\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

// phpcs:disable
final class Version20190312220423 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create images table';
    }

    public function up(Schema $schema): void
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on "mysql"'
        );

        $this->addSql("
            CREATE TABLE images (
                uuid        CHAR(36)   NOT NULL,
                hash        CHAR(40)   NOT NULL,
                name        CHAR(255)  NOT NULL,
                uploaded_at DATETIME   NOT NULL,
                PRIMARY KEY (uuid)
            ) ENGINE = InnoDB DEFAULT CHARACTER SET utf8
        ");
    }

    public function down(Schema $schema): void
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on "mysql"'
        );

        $this->addSql('DROP TABLE images');
    }
}
