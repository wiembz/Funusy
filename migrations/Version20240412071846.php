<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240412071846 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE investissement (id_investissement INT AUTO_INCREMENT NOT NULL, id_user INT DEFAULT NULL, id_projet INT DEFAULT NULL, montant DOUBLE PRECISION NOT NULL, date_inv DATE NOT NULL, periode INT NOT NULL, INDEX IDX_B8E64E016B3CA4B (id_user), INDEX IDX_B8E64E0176222944 (id_projet), PRIMARY KEY(id_investissement)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE investissement ADD CONSTRAINT FK_B8E64E016B3CA4B FOREIGN KEY (id_user) REFERENCES user (id_user)');
        $this->addSql('ALTER TABLE investissement ADD CONSTRAINT FK_B8E64E0176222944 FOREIGN KEY (id_projet) REFERENCES projet (id_projet)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE investissement DROP FOREIGN KEY FK_B8E64E016B3CA4B');
        $this->addSql('ALTER TABLE investissement DROP FOREIGN KEY FK_B8E64E0176222944');
        $this->addSql('DROP TABLE investissement');
    }
}
