<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class Version0002_CreateEntity_Corolla.
 */
final class Version0002_CreateEntity_Corolla extends AbstractMigration
{
    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('
            CREATE TABLE corollas (
                id            INT AUTO_INCREMENT NOT NULL,
                corolla_class INT                NOT NULL,
                image         VARCHAR(1024)      NOT NULL,
                INDEX IDX_9EE708F4A64A6311 (corolla_class),
                PRIMARY KEY(id)
            )
            DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        ');
        $this->addSql('ALTER TABLE corollas ADD CONSTRAINT FK_9EE708F4A64A6311 FOREIGN KEY (corolla_class) REFERENCES klas (id) ON DELETE CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE corollas');
    }
}
