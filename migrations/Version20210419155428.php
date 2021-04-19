<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210419155428 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adherent DROP categorie_fourmi');
        $this->addSql('ALTER TABLE adhesion_bibliotheque ADD categorie_fourmi VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE objet ADD date_sortie_stock DATE DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adherent ADD categorie_fourmi VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE adhesion_bibliotheque DROP categorie_fourmi');
        $this->addSql('ALTER TABLE objet DROP date_sortie_stock');
    }
}
