<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210507094416 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE distributor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD distributor_id INT DEFAULT NULL, DROP head');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6492D863A58 FOREIGN KEY (distributor_id) REFERENCES distributor (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6492D863A58 ON user (distributor_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6492D863A58');
        $this->addSql('DROP TABLE distributor');
        $this->addSql('DROP INDEX IDX_8D93D6492D863A58 ON user');
        $this->addSql('ALTER TABLE user ADD head LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', DROP distributor_id');
    }
}
