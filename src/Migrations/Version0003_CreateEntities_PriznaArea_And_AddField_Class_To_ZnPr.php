<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class Version0003_CreateEntities_PriznaArea_And_AddField_Class_To_ZnPr.
 */
final class Version0003_CreateEntities_PriznaArea_And_AddField_Class_To_ZnPr extends AbstractMigration
{

    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('
            CREATE TABLE prizna_area (
                id          INT AUTO_INCREMENT NOT NULL,
                prizn_id_id INT                DEFAULT NULL,
                zn          VARCHAR(255)       NOT NULL,
                INDEX IDX_FEFB5D34357EE8CD (prizn_id_id),
                PRIMARY KEY(id)
            )
            DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        ');
        $this->addSql('ALTER TABLE prizna_area ADD CONSTRAINT FK_FEFB5D34357EE8CD FOREIGN KEY (prizn_id_id) REFERENCES prizn (id)');
        $this->addSql('ALTER TABLE zn_pr ADD prizna_area_id INT DEFAULT NULL, ADD class INT NOT NULL, DROP name');
        $this->addSql('ALTER TABLE zn_pr ADD CONSTRAINT FK_586D8F286059800F FOREIGN KEY (prizna_area_id) REFERENCES prizna_area (id)');
        $this->addSql('ALTER TABLE zn_pr ADD CONSTRAINT FK_586D8F28ED4B199F FOREIGN KEY (class) REFERENCES klas (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_586D8F286059800F ON zn_pr (prizna_area_id)');
        $this->addSql('CREATE INDEX IDX_586D8F28ED4B199F ON zn_pr (class)');
    }

    /**
     * {@inheritdoc}
     */
    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE zn_pr DROP FOREIGN KEY FK_586D8F286059800F');
        $this->addSql('DROP TABLE prizna_area');
        $this->addSql('ALTER TABLE zn_pr DROP FOREIGN KEY FK_586D8F28ED4B199F');
        $this->addSql('DROP INDEX IDX_586D8F286059800F ON zn_pr');
        $this->addSql('DROP INDEX IDX_586D8F28ED4B199F ON zn_pr');
        $this->addSql('ALTER TABLE zn_pr ADD name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP prizna_area_id, DROP class');
    }
}
