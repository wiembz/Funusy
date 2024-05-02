<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240425130034 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE compte ADD CONSTRAINT FK_CFF652606B3CA4B FOREIGN KEY (id_user) REFERENCES user (id_user)');
        $this->addSql('DROP INDEX fk_user_2 ON compte');
        $this->addSql('CREATE INDEX IDX_CFF652606B3CA4B ON compte (id_user)');
        $this->addSql('DROP INDEX fk_user_credit ON credit');
        $this->addSql('ALTER TABLE credit ADD status VARCHAR(255) DEFAULT \'Non traité\', DROP id_user');
        $this->addSql('DROP INDEX id_credit ON garantie');
        $this->addSql('ALTER TABLE garantie CHANGE preuve preuve VARCHAR(8000) DEFAULT NULL');
        $this->addSql('DROP INDEX fk_user_inv ON investissement');
        $this->addSql('ALTER TABLE investissement ADD id_projet INT NOT NULL');
        $this->addSql('ALTER TABLE projet ADD description VARCHAR(250) NOT NULL, CHANGE id_user id_user INT DEFAULT NULL');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA96B3CA4B FOREIGN KEY (id_user) REFERENCES user (id_user)');
        $this->addSql('DROP INDEX fk_user_projet ON projet');
        $this->addSql('CREATE INDEX IDX_50159CA96B3CA4B ON projet (id_user)');
        $this->addSql('ALTER TABLE signale CHANGE id_commentaire id_commentaire INT DEFAULT NULL');
        $this->addSql('ALTER TABLE signale ADD CONSTRAINT FK_2279705C7FE2A54B FOREIGN KEY (id_commentaire) REFERENCES commentaire (id_commentaire)');
        $this->addSql('DROP INDEX fk_commentaire ON signale');
        $this->addSql('CREATE INDEX IDX_2279705C7FE2A54B ON signale (id_commentaire)');
        $this->addSql('ALTER TABLE transaction CHANGE rib rib VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1BFB7B5B6 FOREIGN KEY (rib) REFERENCES compte (rib)');
        $this->addSql('DROP INDEX fk_rib_tran ON transaction');
        $this->addSql('CREATE INDEX IDX_723705D1BFB7B5B6 ON transaction (rib)');
        $this->addSql('DROP INDEX unique_email_user ON user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE compte DROP FOREIGN KEY FK_CFF652606B3CA4B');
        $this->addSql('ALTER TABLE compte DROP FOREIGN KEY FK_CFF652606B3CA4B');
        $this->addSql('DROP INDEX idx_cff652606b3ca4b ON compte');
        $this->addSql('CREATE INDEX fk_user_2 ON compte (id_user)');
        $this->addSql('ALTER TABLE compte ADD CONSTRAINT FK_CFF652606B3CA4B FOREIGN KEY (id_user) REFERENCES user (id_user)');
        $this->addSql('ALTER TABLE credit ADD id_user INT NOT NULL, DROP status');
        $this->addSql('CREATE INDEX fk_user_credit ON credit (id_user)');
        $this->addSql('ALTER TABLE garantie CHANGE preuve preuve BLOB DEFAULT NULL');
        $this->addSql('CREATE INDEX id_credit ON garantie (id_credit)');
        $this->addSql('ALTER TABLE investissement DROP id_projet');
        $this->addSql('CREATE INDEX fk_user_inv ON investissement (id_user)');
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA96B3CA4B');
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA96B3CA4B');
        $this->addSql('ALTER TABLE projet DROP description, CHANGE id_user id_user INT NOT NULL');
        $this->addSql('DROP INDEX idx_50159ca96b3ca4b ON projet');
        $this->addSql('CREATE INDEX fk_user_projet ON projet (id_user)');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA96B3CA4B FOREIGN KEY (id_user) REFERENCES user (id_user)');
        $this->addSql('ALTER TABLE signale DROP FOREIGN KEY FK_2279705C7FE2A54B');
        $this->addSql('ALTER TABLE signale DROP FOREIGN KEY FK_2279705C7FE2A54B');
        $this->addSql('ALTER TABLE signale CHANGE id_commentaire id_commentaire INT NOT NULL');
        $this->addSql('DROP INDEX idx_2279705c7fe2a54b ON signale');
        $this->addSql('CREATE INDEX fk_commentaire ON signale (id_commentaire)');
        $this->addSql('ALTER TABLE signale ADD CONSTRAINT FK_2279705C7FE2A54B FOREIGN KEY (id_commentaire) REFERENCES commentaire (id_commentaire)');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1BFB7B5B6');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1BFB7B5B6');
        $this->addSql('ALTER TABLE transaction CHANGE rib rib VARCHAR(20) NOT NULL');
        $this->addSql('DROP INDEX idx_723705d1bfb7b5b6 ON transaction');
        $this->addSql('CREATE INDEX fk_rib_tran ON transaction (rib)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1BFB7B5B6 FOREIGN KEY (rib) REFERENCES compte (rib)');
        $this->addSql('CREATE UNIQUE INDEX unique_email_user ON user (email_user)');
    }
}
