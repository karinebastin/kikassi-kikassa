<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210414200538 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adherent CHANGE montant_cotisation montant_cotisation NUMERIC(10, 2) DEFAULT NULL');
        $this->addSql('ALTER TABLE emprunt CHANGE penalites penalites NUMERIC(10, 2) DEFAULT NULL, CHANGE prix_emprunt prix_emprunt NUMERIC(10, 2) NOT NULL');
        $this->addSql('ALTER TABLE objet CHANGE valeur_achat valeur_achat NUMERIC(10, 2) NOT NULL, CHANGE pourcent_calcul pourcent_calcul NUMERIC(10, 2) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adherent CHANGE montant_cotisation montant_cotisation INT DEFAULT NULL');
        $this->addSql('ALTER TABLE emprunt CHANGE penalites penalites INT DEFAULT NULL, CHANGE prix_emprunt prix_emprunt DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE objet CHANGE valeur_achat valeur_achat INT NOT NULL, CHANGE pourcent_calcul pourcent_calcul INT NOT NULL');
    }
}
