<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240417165602 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE garantie DROP FOREIGN KEY FK_7193C6283AF6DB13');
        $this->addSql('DROP INDEX IDX_7193C6283AF6DB13 ON garantie');
        $this->addSql('ALTER TABLE garantie CHANGE preuve preuve VARCHAR(255) DEFAULT NULL, CHANGE nature_garantie preuveOriginalFilename VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE garantie CHANGE preuve preuve VARCHAR(8000) DEFAULT NULL, CHANGE preuveOriginalFilename nature_garantie VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE garantie ADD CONSTRAINT FK_7193C6283AF6DB13 FOREIGN KEY (id_credit) REFERENCES credit (id_credit)');
        $this->addSql('CREATE INDEX IDX_7193C6283AF6DB13 ON garantie (id_credit)');
    }
}
