<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Infrastructure\Sql\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

// phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter
final class Version20190312220423 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create images table';
    }

    public function up(Schema $schema): void
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'postgresql',
            'Migration can only be executed safely on "postgres"'
        );

        $this->addSql("
            CREATE TABLE images (
                uuid        UUID          NOT NULL,
                hash        CHAR(40)      NOT NULL,
                name        VARCHAR(255)  NOT NULL,
                uploaded_at TIMESTAMP     NOT NULL,
                PRIMARY KEY (uuid)
            )
        ");
    }

    public function down(Schema $schema): void
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'postgresql',
            'Migration can only be executed safely on "postgres"'
        );

        $this->addSql('DROP TABLE images');
    }
}
