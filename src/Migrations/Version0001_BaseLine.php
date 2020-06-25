<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class Version0001_BaseLine.
 */
final class Version0001_BaseLine extends AbstractMigration
{
    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('
            CREATE TABLE ceramic_category (
                id   INT AUTO_INCREMENT NOT NULL,
                name VARCHAR(255)       NOT NULL,
                PRIMARY KEY(id)
            )
            DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        ');
        $this->addSql('
            CREATE TABLE artefacts (
                id       INT AUTO_INCREMENT NOT NULL,
                user_id  INT                NOT NULL,
                klas_id  INT                NOT NULL,
                kl_pr_id INT                NOT NULL,
                zn_pr_id INT                NOT NULL,
                name     VARCHAR(255)       NOT NULL,
                date     DATE               NOT NULL,
                place    VARCHAR(255)       NOT NULL,
                period   VARCHAR(255)       NOT NULL,
                UNIQUE INDEX UNIQ_5E5C86F35E237E06 (name),
                INDEX IDX_5E5C86F3A76ED395 (user_id),
                INDEX IDX_5E5C86F32F3345ED (klas_id),
                INDEX IDX_5E5C86F3F8896BCD (kl_pr_id),
                INDEX IDX_5E5C86F3DF074B51 (zn_pr_id),
                PRIMARY KEY(id)
            )
            DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        ');
        $this->addSql('
            CREATE TABLE kl_pr (
                id    INT AUTO_INCREMENT NOT NULL,
                kl_id INT                DEFAULT NULL,
                pr_id INT                DEFAULT NULL,
                INDEX IDX_AFE4F991C030E5D8 (kl_id),
                INDEX IDX_AFE4F99167C663E7 (pr_id),
                PRIMARY KEY(id)
            )
            DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        ');
        $this->addSql('
            CREATE TABLE farfor_category (
                id          INT AUTO_INCREMENT NOT NULL,
                relation_id INT                DEFAULT NULL,
                name        VARCHAR(255)       DEFAULT NULL,
                INDEX IDX_441783DA3256915B (relation_id),
                PRIMARY KEY(id)
            )
            DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        ');
        $this->addSql('
            CREATE TABLE ceramic (
                id                  INT AUTO_INCREMENT NOT NULL,
                ceramic_category_id INT                NOT NULL,
                name                VARCHAR(255)       NOT NULL,
                description         VARCHAR(255)       NOT NULL,
                INDEX IDX_5F088C592EEE268A (ceramic_category_id),
                PRIMARY KEY(id)
            )
            DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        ');
        $this->addSql('
            CREATE TABLE klas (
                id   INT AUTO_INCREMENT NOT NULL,
                name VARCHAR(255)       NOT NULL,
                PRIMARY KEY(id)
            )
            DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        ');
        $this->addSql('
            CREATE TABLE zn_pr (
                id    INT AUTO_INCREMENT NOT NULL,
                pr_id INT                DEFAULT NULL,
                name  VARCHAR(255)       NOT NULL,
                INDEX IDX_586D8F2867C663E7 (pr_id),
                PRIMARY KEY(id)
            )
            DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        ');
        $this->addSql('
            CREATE TABLE farfor (
                id          INT AUTO_INCREMENT NOT NULL,
                name        VARCHAR(255)       NOT NULL,
                description VARCHAR(255)       NOT NULL,
                PRIMARY KEY(id)
            )
            DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        ');
        $this->addSql('
            CREATE TABLE user (
                id         INT AUTO_INCREMENT NOT NULL,
                username   VARCHAR(255)       NOT NULL,
                email      VARCHAR(255)       NOT NULL,
                password   VARCHAR(64)        NOT NULL,
                roles      JSON               NOT NULL,
                UNIQUE INDEX UNIQ_8D93D649F85E0677 (username),
                PRIMARY KEY(id)
            )
            DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        ');
        $this->addSql('
            CREATE TABLE prizn (
                id   INT AUTO_INCREMENT NOT NULL,
                name VARCHAR(255)       NOT NULL,
                PRIMARY KEY(id)
            )
            DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        ');
        $this->addSql('ALTER TABLE artefacts ADD CONSTRAINT FK_5E5C86F3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE artefacts ADD CONSTRAINT FK_5E5C86F32F3345ED FOREIGN KEY (klas_id) REFERENCES klas (id)');
        $this->addSql('ALTER TABLE artefacts ADD CONSTRAINT FK_5E5C86F3F8896BCD FOREIGN KEY (kl_pr_id) REFERENCES kl_pr (id)');
        $this->addSql('ALTER TABLE artefacts ADD CONSTRAINT FK_5E5C86F3DF074B51 FOREIGN KEY (zn_pr_id) REFERENCES zn_pr (id)');
        $this->addSql('ALTER TABLE kl_pr ADD CONSTRAINT FK_AFE4F991C030E5D8 FOREIGN KEY (kl_id) REFERENCES klas (id)');
        $this->addSql('ALTER TABLE kl_pr ADD CONSTRAINT FK_AFE4F99167C663E7 FOREIGN KEY (pr_id) REFERENCES prizn (id)');
        $this->addSql('ALTER TABLE farfor_category ADD CONSTRAINT FK_441783DA3256915B FOREIGN KEY (relation_id) REFERENCES farfor (id)');
        $this->addSql('ALTER TABLE ceramic ADD CONSTRAINT FK_5F088C592EEE268A FOREIGN KEY (ceramic_category_id) REFERENCES ceramic_category (id)');
        $this->addSql('ALTER TABLE zn_pr ADD CONSTRAINT FK_586D8F2867C663E7 FOREIGN KEY (pr_id) REFERENCES prizn (id)');
    }

    /**
     * {@inheritdoc}
     */
    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ceramic DROP FOREIGN KEY FK_5F088C592EEE268A');
        $this->addSql('ALTER TABLE artefacts DROP FOREIGN KEY FK_5E5C86F3F8896BCD');
        $this->addSql('ALTER TABLE artefacts DROP FOREIGN KEY FK_5E5C86F32F3345ED');
        $this->addSql('ALTER TABLE kl_pr DROP FOREIGN KEY FK_AFE4F991C030E5D8');
        $this->addSql('ALTER TABLE artefacts DROP FOREIGN KEY FK_5E5C86F3DF074B51');
        $this->addSql('ALTER TABLE farfor_category DROP FOREIGN KEY FK_441783DA3256915B');
        $this->addSql('ALTER TABLE artefacts DROP FOREIGN KEY FK_5E5C86F3A76ED395');
        $this->addSql('ALTER TABLE kl_pr DROP FOREIGN KEY FK_AFE4F99167C663E7');
        $this->addSql('ALTER TABLE zn_pr DROP FOREIGN KEY FK_586D8F2867C663E7');
        $this->addSql('DROP TABLE ceramic_category');
        $this->addSql('DROP TABLE artefacts');
        $this->addSql('DROP TABLE kl_pr');
        $this->addSql('DROP TABLE farfor_category');
        $this->addSql('DROP TABLE ceramic');
        $this->addSql('DROP TABLE klas');
        $this->addSql('DROP TABLE zn_pr');
        $this->addSql('DROP TABLE farfor');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE prizn');
    }
}
