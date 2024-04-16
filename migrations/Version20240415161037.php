<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240415161037 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE echeance (numero INT AUTO_INCREMENT NOT NULL, echeance DATE DEFAULT NULL, principal DOUBLE PRECISION DEFAULT NULL, valeurResiduelle DOUBLE PRECISION DEFAULT NULL, interets DOUBLE PRECISION DEFAULT NULL, mensualite DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(numero)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agence CHANGE code_agence code_agence INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE carte_bancaire DROP FOREIGN KEY fk_rib_2');
        $this->addSql('DROP INDEX fk_rib_2 ON carte_bancaire');
        $this->addSql('ALTER TABLE carte_bancaire ADD rib_id VARCHAR(20) DEFAULT NULL, DROP rib');
        $this->addSql('ALTER TABLE carte_bancaire ADD CONSTRAINT FK_59E3C22D6B253BFF FOREIGN KEY (rib_id) REFERENCES compte (rib) ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_59E3C22D6B253BFF ON carte_bancaire (rib_id)');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY fk_projet');
        $this->addSql('ALTER TABLE commentaire CHANGE id_projet id_projet INT DEFAULT NULL');
        $this->addSql('DROP INDEX fk_projet ON commentaire');
        $this->addSql('CREATE INDEX IDX_67F068BC76222944 ON commentaire (id_projet)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT fk_projet FOREIGN KEY (id_projet) REFERENCES projet (id_projet)');
        $this->addSql('ALTER TABLE compte DROP FOREIGN KEY fk_user_2');
        $this->addSql('ALTER TABLE compte CHANGE id_user id_user INT DEFAULT NULL');
        $this->addSql('DROP INDEX fk_user_2 ON compte');
        $this->addSql('CREATE INDEX IDX_CFF652606B3CA4B ON compte (id_user)');
        $this->addSql('ALTER TABLE compte ADD CONSTRAINT fk_user_2 FOREIGN KEY (id_user) REFERENCES user (id_user)');
        $this->addSql('ALTER TABLE credit DROP FOREIGN KEY fk_user_credit');
        $this->addSql('DROP INDEX fk_user_credit ON credit');
        $this->addSql('ALTER TABLE credit ADD status VARCHAR(255) DEFAULT \'Non traité\', DROP id_user');
        $this->addSql('DROP INDEX id_credit ON garantie');
        $this->addSql('ALTER TABLE garantie CHANGE preuve preuve VARCHAR(8000) DEFAULT NULL');
        $this->addSql('ALTER TABLE investissement DROP FOREIGN KEY fk_user_inv');
        $this->addSql('DROP INDEX fk_user_inv ON investissement');
        $this->addSql('ALTER TABLE investissement ADD id_projet INT NOT NULL');
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY fk_user_projet');
        $this->addSql('ALTER TABLE projet ADD description VARCHAR(255) NOT NULL, CHANGE id_user id_user INT DEFAULT NULL');
        $this->addSql('DROP INDEX fk_user_projet ON projet');
        $this->addSql('CREATE INDEX IDX_50159CA96B3CA4B ON projet (id_user)');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT fk_user_projet FOREIGN KEY (id_user) REFERENCES user (id_user)');
        $this->addSql('ALTER TABLE signale DROP FOREIGN KEY fk_commentaire');
        $this->addSql('ALTER TABLE signale ADD etat_signal TINYINT(1) NOT NULL, CHANGE id_commentaire id_commentaire INT DEFAULT NULL');
        $this->addSql('DROP INDEX fk_commentaire ON signale');
        $this->addSql('CREATE INDEX IDX_2279705C7FE2A54B ON signale (id_commentaire)');
        $this->addSql('ALTER TABLE signale ADD CONSTRAINT fk_commentaire FOREIGN KEY (id_commentaire) REFERENCES commentaire (id_commentaire)');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY fk_rib_tran');
        $this->addSql('ALTER TABLE transaction CHANGE rib rib VARCHAR(20) DEFAULT NULL');
        $this->addSql('DROP INDEX fk_rib_tran ON transaction');
        $this->addSql('CREATE INDEX IDX_723705D1BFB7B5B6 ON transaction (rib)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT fk_rib_tran FOREIGN KEY (rib) REFERENCES compte (rib)');
        $this->addSql('ALTER TABLE user ADD numeric_code VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE echeance');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE agence CHANGE code_agence code_agence INT NOT NULL');
        $this->addSql('ALTER TABLE carte_bancaire DROP FOREIGN KEY FK_59E3C22D6B253BFF');
        $this->addSql('DROP INDEX UNIQ_59E3C22D6B253BFF ON carte_bancaire');
        $this->addSql('ALTER TABLE carte_bancaire ADD rib VARCHAR(20) NOT NULL, DROP rib_id');
        $this->addSql('ALTER TABLE carte_bancaire ADD CONSTRAINT fk_rib_2 FOREIGN KEY (rib) REFERENCES compte (rib)');
        $this->addSql('CREATE INDEX fk_rib_2 ON carte_bancaire (rib)');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC76222944');
        $this->addSql('ALTER TABLE commentaire CHANGE id_projet id_projet INT NOT NULL');
        $this->addSql('DROP INDEX idx_67f068bc76222944 ON commentaire');
        $this->addSql('CREATE INDEX fk_projet ON commentaire (id_projet)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC76222944 FOREIGN KEY (id_projet) REFERENCES projet (id_projet)');
        $this->addSql('ALTER TABLE compte DROP FOREIGN KEY FK_CFF652606B3CA4B');
        $this->addSql('ALTER TABLE compte CHANGE id_user id_user INT NOT NULL');
        $this->addSql('DROP INDEX idx_cff652606b3ca4b ON compte');
        $this->addSql('CREATE INDEX fk_user_2 ON compte (id_user)');
        $this->addSql('ALTER TABLE compte ADD CONSTRAINT FK_CFF652606B3CA4B FOREIGN KEY (id_user) REFERENCES user (id_user)');
        $this->addSql('ALTER TABLE credit ADD id_user INT NOT NULL, DROP status');
        $this->addSql('ALTER TABLE credit ADD CONSTRAINT fk_user_credit FOREIGN KEY (id_user) REFERENCES user (id_user)');
        $this->addSql('CREATE INDEX fk_user_credit ON credit (id_user)');
        $this->addSql('ALTER TABLE garantie CHANGE preuve preuve BLOB DEFAULT NULL');
        $this->addSql('CREATE INDEX id_credit ON garantie (id_credit)');
        $this->addSql('ALTER TABLE investissement DROP id_projet');
        $this->addSql('ALTER TABLE investissement ADD CONSTRAINT fk_user_inv FOREIGN KEY (id_user) REFERENCES user (id_user)');
        $this->addSql('CREATE INDEX fk_user_inv ON investissement (id_user)');
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA96B3CA4B');
        $this->addSql('ALTER TABLE projet DROP description, CHANGE id_user id_user INT NOT NULL');
        $this->addSql('DROP INDEX idx_50159ca96b3ca4b ON projet');
        $this->addSql('CREATE INDEX fk_user_projet ON projet (id_user)');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA96B3CA4B FOREIGN KEY (id_user) REFERENCES user (id_user)');
        $this->addSql('ALTER TABLE signale DROP FOREIGN KEY FK_2279705C7FE2A54B');
        $this->addSql('ALTER TABLE signale DROP etat_signal, CHANGE id_commentaire id_commentaire INT NOT NULL');
        $this->addSql('DROP INDEX idx_2279705c7fe2a54b ON signale');
        $this->addSql('CREATE INDEX fk_commentaire ON signale (id_commentaire)');
        $this->addSql('ALTER TABLE signale ADD CONSTRAINT FK_2279705C7FE2A54B FOREIGN KEY (id_commentaire) REFERENCES commentaire (id_commentaire)');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1BFB7B5B6');
        $this->addSql('ALTER TABLE transaction CHANGE rib rib VARCHAR(20) NOT NULL');
        $this->addSql('DROP INDEX idx_723705d1bfb7b5b6 ON transaction');
        $this->addSql('CREATE INDEX fk_rib_tran ON transaction (rib)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1BFB7B5B6 FOREIGN KEY (rib) REFERENCES compte (rib)');
        $this->addSql('ALTER TABLE user DROP numeric_code');
    }
}
