<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210403143211 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adherent ADD etat_cotisation VARCHAR(255) NOT NULL, CHANGE montant_cotisation montant_cotisation INT DEFAULT NULL, CHANGE moyen_paiement moyen_paiement VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE lieu ADD raison_fermeture VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE objet ADD observation LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adherent DROP etat_cotisation, CHANGE montant_cotisation montant_cotisation INT NOT NULL, CHANGE moyen_paiement moyen_paiement VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE lieu DROP raison_fermeture');
        $this->addSql('ALTER TABLE objet DROP observation');
    }
}
