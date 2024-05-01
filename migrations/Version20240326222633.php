<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240326222633 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agence (code_agence INT AUTO_INCREMENT NOT NULL, adresse VARCHAR(255) NOT NULL, codepostal INT NOT NULL, PRIMARY KEY(code_agence)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE carte_bancaire (num_carte VARCHAR(16) NOT NULL, rib_id VARCHAR(20) DEFAULT NULL, date_exp DATE NOT NULL, code INT NOT NULL, CVV2 INT NOT NULL, UNIQUE INDEX UNIQ_59E3C22D6B253BFF (rib_id), PRIMARY KEY(num_carte)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id_commentaire INT AUTO_INCREMENT NOT NULL, id_projet INT DEFAULT NULL, contenue VARCHAR(255) NOT NULL, date_commentaire DATE NOT NULL, INDEX IDX_67F068BC76222944 (id_projet), PRIMARY KEY(id_commentaire)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE compte (rib VARCHAR(20) NOT NULL, id_user INT DEFAULT NULL, solde DOUBLE PRECISION NOT NULL, date_ouverture DATE NOT NULL, type_compte VARCHAR(255) NOT NULL, INDEX IDX_CFF652606B3CA4B (id_user), PRIMARY KEY(rib)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE credit (id_credit INT AUTO_INCREMENT NOT NULL, montant_credit DOUBLE PRECISION NOT NULL, duree_credit INT NOT NULL, date_credit DATE NOT NULL, taux_credit DOUBLE PRECISION NOT NULL, status VARCHAR(255) DEFAULT \'Non traité\', PRIMARY KEY(id_credit)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE echeance (numero INT AUTO_INCREMENT NOT NULL, echeance DATE DEFAULT NULL, principal DOUBLE PRECISION DEFAULT NULL, valeurResiduelle DOUBLE PRECISION DEFAULT NULL, interets DOUBLE PRECISION DEFAULT NULL, mensualite DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(numero)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE garantie (id_garantie INT AUTO_INCREMENT NOT NULL, id_credit INT DEFAULT NULL, nature_garantie VARCHAR(255) NOT NULL, Valeur_Garantie DOUBLE PRECISION DEFAULT NULL, preuve VARCHAR(8000) DEFAULT NULL, PRIMARY KEY(id_garantie)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE investissement (id_investissement INT AUTO_INCREMENT NOT NULL, montant DOUBLE PRECISION NOT NULL, date_inv DATE NOT NULL, periode INT NOT NULL, id_user INT NOT NULL, id_projet INT NOT NULL, PRIMARY KEY(id_investissement)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projet (id_projet INT AUTO_INCREMENT NOT NULL, id_user INT DEFAULT NULL, nom_projet VARCHAR(255) NOT NULL, montant_req DOUBLE PRECISION NOT NULL, longitude VARCHAR(255) NOT NULL, latitude VARCHAR(255) NOT NULL, type_projet VARCHAR(255) NOT NULL, description VARCHAR(250) NOT NULL, INDEX IDX_50159CA96B3CA4B (id_user), PRIMARY KEY(id_projet)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE signale (id_signal INT AUTO_INCREMENT NOT NULL, id_commentaire INT DEFAULT NULL, date_signal DATE NOT NULL, description VARCHAR(255) NOT NULL, etat_signal TINYINT(1) NOT NULL, INDEX IDX_2279705C7FE2A54B (id_commentaire), PRIMARY KEY(id_signal)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction (id_transaction INT AUTO_INCREMENT NOT NULL, rib VARCHAR(20) DEFAULT NULL, montant_transaction DOUBLE PRECISION NOT NULL, date_transaction DATE NOT NULL, destination VARCHAR(20) NOT NULL, type_transaction VARCHAR(255) DEFAULT NULL, INDEX IDX_723705D1BFB7B5B6 (rib), PRIMARY KEY(id_transaction)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id_user INT AUTO_INCREMENT NOT NULL, nom_user VARCHAR(255) NOT NULL, prenom_user VARCHAR(255) NOT NULL, email_user VARCHAR(255) NOT NULL, mdp VARCHAR(255) NOT NULL, salaire DOUBLE PRECISION NOT NULL, date_naissance DATE NOT NULL, CIN INT NOT NULL, tel INT NOT NULL, adresse_user VARCHAR(255) NOT NULL, role_user VARCHAR(255) NOT NULL, numeric_code VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id_user)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE carte_bancaire ADD CONSTRAINT FK_59E3C22D6B253BFF FOREIGN KEY (rib_id) REFERENCES compte (rib) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC76222944 FOREIGN KEY (id_projet) REFERENCES projet (id_projet)');
        $this->addSql('ALTER TABLE compte ADD CONSTRAINT FK_CFF652606B3CA4B FOREIGN KEY (id_user) REFERENCES user (id_user)');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA96B3CA4B FOREIGN KEY (id_user) REFERENCES user (id_user)');
        $this->addSql('ALTER TABLE signale ADD CONSTRAINT FK_2279705C7FE2A54B FOREIGN KEY (id_commentaire) REFERENCES commentaire (id_commentaire)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1BFB7B5B6 FOREIGN KEY (rib) REFERENCES compte (rib)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carte_bancaire DROP FOREIGN KEY FK_59E3C22D6B253BFF');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC76222944');
        $this->addSql('ALTER TABLE compte DROP FOREIGN KEY FK_CFF652606B3CA4B');
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA96B3CA4B');
        $this->addSql('ALTER TABLE signale DROP FOREIGN KEY FK_2279705C7FE2A54B');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1BFB7B5B6');
        $this->addSql('DROP TABLE agence');
        $this->addSql('DROP TABLE carte_bancaire');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE compte');
        $this->addSql('DROP TABLE credit');
        $this->addSql('DROP TABLE echeance');
        $this->addSql('DROP TABLE garantie');
        $this->addSql('DROP TABLE investissement');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('DROP TABLE projet');
        $this->addSql('DROP TABLE signale');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('DROP TABLE user');
    }
}
