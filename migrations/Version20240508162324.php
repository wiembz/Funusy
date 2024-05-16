<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240508162324 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carte_bancaire DROP FOREIGN KEY FK_59E3C22D6B253BFF');
        $this->addSql('DROP INDEX UNIQ_59E3C22D6B253BFF ON carte_bancaire');
        $this->addSql('ALTER TABLE carte_bancaire ADD rib VARCHAR(20) NOT NULL, DROP rib_id, CHANGE num_carte num_carte VARCHAR(19) NOT NULL, CHANGE date_exp date_exp DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE credit ADD id_user INT DEFAULT NULL');
        $this->addSql('ALTER TABLE credit ADD CONSTRAINT FK_1CC16EFE6B3CA4B FOREIGN KEY (id_user) REFERENCES user (id_user)');
        $this->addSql('CREATE INDEX IDX_1CC16EFE6B3CA4B ON credit (id_user)');
        $this->addSql('ALTER TABLE garantie CHANGE preuve preuve VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE projet CHANGE description description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE signale DROP etat_signal, CHANGE description description VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE transaction CHANGE type_transaction type_transaction VARCHAR(20) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carte_bancaire ADD rib_id VARCHAR(20) DEFAULT NULL, DROP rib, CHANGE num_carte num_carte VARCHAR(16) NOT NULL, CHANGE date_exp date_exp DATE NOT NULL');
        $this->addSql('ALTER TABLE carte_bancaire ADD CONSTRAINT FK_59E3C22D6B253BFF FOREIGN KEY (rib_id) REFERENCES compte (rib) ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_59E3C22D6B253BFF ON carte_bancaire (rib_id)');
        $this->addSql('ALTER TABLE credit DROP FOREIGN KEY FK_1CC16EFE6B3CA4B');
        $this->addSql('DROP INDEX IDX_1CC16EFE6B3CA4B ON credit');
        $this->addSql('ALTER TABLE credit DROP id_user');
        $this->addSql('ALTER TABLE garantie CHANGE preuve preuve VARCHAR(8000) DEFAULT NULL');
        $this->addSql('ALTER TABLE projet CHANGE description description VARCHAR(250) NOT NULL');
        $this->addSql('ALTER TABLE signale ADD etat_signal TINYINT(1) NOT NULL, CHANGE description description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE transaction CHANGE type_transaction type_transaction VARCHAR(255) DEFAULT NULL');
    }
}
